<?php

namespace App\Http\Controllers\Report\Sale;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use App\Models\Company;
use App\Models\Order;
use App\Models\Cart;
use App\Models\PaymentDetail;

class SaleReportController extends Controller
{
    public function daily()
    {
        $company = Company::first();

        $orders = Order::with('user')->whereDate('date', Carbon::today())->latest()->get();
        $paymentDetails = PaymentDetail::with(['user','paymentMethod','order'])->whereDate('date', Carbon::today())->latest()->paginate(15);
        
        $summary = [
            'orders_count' => $orders->count(),
            'total_sales'  => $orders->sum('total'),
            'total_pay'    => $paymentDetails->sum('pay'),
            'total_due'    => $paymentDetails->sum('due'),
        ];

        return view('report.sale.daily-report', compact('company', 'orders','paymentDetails','summary'));
    }

    public function orderDetails($reg)
    {
        $company = Company::first();

        $cart = Cart::with(['user','product'])->where('reg', $reg)->get();

        $order = Order::with(['user'])->where('reg', $reg)->firstOrFail();

        // One order may have multiple payment rows (partial payments)
        $payments = PaymentDetail::with(['paymentMethod','user'])->where('reg', $reg)->orderBy('id', 'desc')->get();

        // Summary from payments (safe)
        $paySummary = [
            'total'    => (float) $payments->sum('total'),
            'discount' => (float) $payments->sum('discount'),
            'vat'      => (float) $payments->sum('vat'),
            'payable'  => (float) $payments->sum('payable'),
            'paid'     => (float) $payments->sum('pay'),
            'due'      => (float) $payments->sum('due'),
        ];

        return view('report.sale.order-details', compact('company','order','payments','paySummary','cart'));
    }
}
