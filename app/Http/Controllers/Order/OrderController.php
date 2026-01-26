<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use App\Models\Company;
use App\Models\Product;
use App\Models\PaymentMethod;
use App\Models\PdrStock;

use App\Models\Cart;
use App\Models\Order;
use App\Models\PaymentDetail;

class OrderController extends Controller
{
    function generateRegNum() {
        $userId = Auth::guard('admin')->user()->id;
        $order = Order::where('user_id', $userId)->count() + 1;
        return '1' . str_pad($userId, 4, '0', STR_PAD_LEFT) . str_pad($order, 8, '0', STR_PAD_LEFT);
    }

    public function checkout(Request $request)
    {
        try{
            
            $request->validate([
                'txtReg'            => 'required',
                'txtSubTotal'       => 'required',
                'txtPay'            => 'nullable|numeric|min:0',
                'paymentMethods'    => 'required',
                'txtCustomerName'   => 'nullable|string|max:255',
                'txtCustomerPhone'  => 'nullable|string|max:20',
            ]);

            $user = Auth::guard('admin')->user() ?? Auth::user();            

            $reg = $request->input('txtReg', '');
            
            if(Order::where('reg', $reg)->exists()) {
                return redirect()->back()->with('error', 'This order already taken. Please add product to cart and try again. Thank You!');
            } 

            if($request->input('txtSubTotal', '') <= 0) {
                return redirect()->back()->with('error', 'Your cart is empty. Try again.');
            }        
            
            // -----------------------------
            // Inputs
            // -----------------------------
            $received  = (float) $request->input('txtPay', 0);
            $total     = (float) $request->input('txtSubTotal', 0);
            $discount  = (float) $request->input('txtDiscount', 0);
            $vat       = (float) $request->input('txtVAT', 0);
            $payMethod = $request->input('paymentMethods');

            // -----------------------------
            // Calculations
            // -----------------------------
            $newVat    = ($total * $vat) / 100;
            $payable  = max(0, ($total - $discount) + $newVat);
            // clamp pay & due
            $payAmount = min($received, $payable);
            $dueAmount = max(0, $payable - $received);

            if ($dueAmount > 0) {
                $request->validate([
                    'txtCustomerName'  => 'required|string|max:255',
                    'txtCustomerPhone' => 'required|string|max:20',
                ]);
            }

            // status: 0=pending,1=ordered,2=cancel etc
            $status = 1;

            try {
                
                DB::transaction(function () use (
                    $request, $user, $reg,
                    $total, $discount, $newVat, $payable,
                    $payMethod, $payAmount, $dueAmount, $status
                ) {
                    // =========================
                    // 1) SAVE ORDER
                    // =========================
                    $order = new Order();
                    $order->date            = Carbon::now()->toDateString();
                    $order->user_id         = $user->id;
                    $order->reg             = $reg;

                    $order->total           = $payable;
                    $order->status          = $status;
                    $order->customerName    = $request->filled('txtCustomerName') ? $request->input('txtCustomerName') : 'Guest';
                    $order->customerPhone   = $request->filled('txtCustomerPhone') ? $request->input('txtCustomerPhone') : '0';

                    $order->save();

                    // =========================
                    // 2) SAVE PAYMENT DETAILS
                    // =========================
                    PaymentDetail::create([
                        'date'              => Carbon::now()->toDateString(),
                        'user_id'           => $user->id,
                        'order_id'          => $order->id,
                        'reg'               => $reg, // ⚠ unique then 1 payment only

                        'total'             => $total,
                        'discount'          => $discount,
                        'vat'               => $newVat,
                        'payable'           => $payable,
                        'pay'               => $payAmount,
                        'due'               => $dueAmount,

                        'payment_method_id' => $payMethod,
                    ]);
                });

                return redirect()->back()->with('success', 'Order sale successfully.')->with('reg', $reg);
            } catch (\Exception $e) {
                throw new \Exception('Transaction failed: ' . $e->getMessage());
            }            
        }  catch (\Exception $e) {            
            DB::rollBack();
            return redirect()->back()->with('error', 'An error occurred while processing your order. '. $e->getMessage());
        }
    }

    public function invoicePrint($reg)
    {
        $company = Company::first();

        $order = Order::where('reg', $reg)->first();
        $paymentDetail = PaymentDetail::where('reg', $reg)->first();

        // eager load product + user
        $cartItems = Cart::with(['product', 'user'])->where('reg', $reg)->get();

        if (!$order || !$paymentDetail || $cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Invalid order details for invoice.');
        }

        // bill officer (Cart user) - first item user
        $billOfficer = optional($cartItems->first())->user;

        // payment method name (optional)
        $paymentMethod = PaymentMethod::find($paymentDetail->payment_method_id);

        return view('invoice.print-invoice', compact(
            'company',
            'order',
            'paymentDetail',
            'cartItems',
            'billOfficer',
            'paymentMethod'
        ));
    }
}
