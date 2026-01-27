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

    public function printDailyReport(){
        $company = Company::first();

        $orders = Order::with('user')->whereDate('date', Carbon::today())->latest()->get();
        $paymentDetails = PaymentDetail::with(['user','paymentMethod','order'])->whereDate('date', Carbon::today())->latest()->get();
        
        $summary = [
            'orders_count' => $orders->count(),
            'total_sales'  => $orders->sum('total'),
            'total_pay'    => $paymentDetails->sum('pay'),
            'total_due'    => $paymentDetails->sum('due'),
        ];

        return view('report.print.print-daily-report', compact('company', 'orders','paymentDetails','summary'));
    }

    public function dateWiseSaleReport(){
        $company = Company::first();

        $orders = Order::with('user')->whereDate('date', Carbon::today())->latest()->get();
        $paymentDetails = PaymentDetail::with(['user','paymentMethod','order'])->whereDate('date', Carbon::today())->latest()->paginate(15);
        
        return view('report.sale.date-wise-report', compact('company', 'orders','paymentDetails'));
    }

    public function filteDateWiseSaleReport(Request $request){

        $request->validate([
            'start_date' => ['nullable', 'date', 'before_or_equal:today'],
            'end_date'   => ['nullable', 'date', 'before_or_equal:today', 'after_or_equal:start_date'],
        ]);

        $company = Company::first();

        $start = $request->start_date ? Carbon::parse($request->start_date)->startOfDay() : Carbon::today()->startOfDay();
        $end   = $request->end_date   ? Carbon::parse($request->end_date)->endOfDay()   : Carbon::today()->endOfDay();

        $orders = Order::with('user')->whereBetween('date', [$start, $end])->latest()->get();
        $paymentDetailsQuery = PaymentDetail::with(['user','paymentMethod','order'])->whereBetween('date', [$start, $end])->latest();

        if ($request->boolean('print')) {
            $paymentDetails = $paymentDetailsQuery->get();   // ✅ print: get()
            return view('report.print.print-date-wise-report', compact('company','orders','paymentDetails','start','end'));
        } else {
            $paymentDetails = $paymentDetailsQuery->paginate(15)->withQueryString();
        }

        return view('report.sale.date-wise-report', compact('company','orders','paymentDetails'));
    }
}
