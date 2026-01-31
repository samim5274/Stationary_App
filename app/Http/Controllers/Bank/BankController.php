<?php

namespace App\Http\Controllers\Bank;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\Rule;

use App\Models\Company;
use App\Models\BankDetail;
use App\Models\BankTransectionDetail;
use App\Models\User;

class BankController extends Controller
{
    public function index(){
        $company = Company::first();
        $banks = BankDetail::get();
        $transections = BankTransectionDetail::with(['bank','user'])->where('date', Carbon::today())->paginate(15);
        $totals = BankTransectionDetail::whereDate('date', Carbon::today())->selectRaw("status, SUM(amount) as total")
                                        ->groupBy('status')->pluck('total', 'status');

        $totalDeposit  = $totals['Deposit'] ?? 0;
        $totalWithdraw = $totals['Withdraw'] ?? 0;

        $balance = $totalDeposit - $totalWithdraw;

        return view('bank.bank-transection', compact(
            'company','banks','transections',
            'totalDeposit','totalWithdraw',
            'balance',
        ));
    }

    public function bankDipositView(){
        $company = Company::first();
        $banks = BankDetail::get();
        $transections = BankTransectionDetail::with(['bank','user'])->where('status', 'Deposit')->where('date', Carbon::today())->paginate(15);
        return view('bank.diposit-view', compact('company','banks','transections'));
    }

    public function bankDiposit(Request $request){
        try{
            $request->validate([
                'bank_id'       => 'required|exists:bank_details,id',
                'amount'        => 'required|numeric|min:0',
                'description'   => 'nullable|string|max:500',
            ]);

            $userId = Auth::guard('admin')->id();

            $data = new BankTransectionDetail();
            $data->bank_id   = $request->bank_id;
            $data->user_id   = $userId;
            $data->amount    = $request->amount;
            $data->date      = Carbon::now()->format('Y-m-d');
            $data->status    = 'Deposit';
            $data->remarks   = $request->description ?? 'N/A';
            $data->save();

            return redirect()->back()->with('success', 'Deposit updated successfully.');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Some thing is wrong..!');
        }
    }

    public function bankWithdrawView(){
        $company = Company::first();
        $banks = BankDetail::get();
        $transections = BankTransectionDetail::with(['bank','user'])->where('status', 'Withdraw')->where('date', Carbon::today())->paginate(15);
        return view('bank.withdraw-view', compact('company','banks','transections'));
    }

    public function bankWithdraw(Request $request){
        try{
            // Validation
            $request->validate([
                'from_bank_id'  => 'required|exists:bank_details,id',
                'amount'        => 'required|numeric|min:0.01',
                'remarks'       => 'nullable|string|max:255',
            ]);

            $userId = Auth::guard('admin')->id();

            // Get Current Bank Balance
            $fromBankBalance = BankTransectionDetail::where('bank_id', $request->from_bank_id)
                ->selectRaw("
                    COALESCE(SUM(CASE WHEN status='Deposit' THEN amount ELSE 0 END),0) -
                    COALESCE(SUM(CASE WHEN status='Withdraw' THEN amount ELSE 0 END),0)
                    AS balance
                ")->value('balance');

            $fromBankBalance = $fromBankBalance ?? 0;

            // Check If Enough Balance
            if ($request->amount > $fromBankBalance) {
                return back()->with('error', 'Insufficient balance! Available balance: ৳ ' . number_format($fromBankBalance, 2));
            }

            // Insert Withdraw Record
            $withdraw = new BankTransectionDetail();
            $withdraw->bank_id   = $request->from_bank_id;
            $withdraw->user_id   = $userId; // Adjust guard if needed
            $withdraw->amount    = $request->amount;
            $withdraw->date      = Carbon::now()->format('Y-m-d');
            $withdraw->status    = 'Withdraw';
            $withdraw->remarks   = $request->remarks ?? 'N/A';
            $withdraw->save();

            return back()->with('success', 'Amount withdrawn successfully.');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Some thing is wrong..!');
        }
    }

    public function dipositDelete($id){
        try{
            $transections = BankTransectionDetail::findOrFail($id);
            // $transections->delete();
            return redirect()->back()->with('success', 'Diposit transection deleted successfully.');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Some thing is wrong..!');
        }
    }

    public function withdrawDelete($id){
        try{
            $transections = BankTransectionDetail::findOrFail($id);
            // $transections->delete();
            return redirect()->back()->with('success', 'Withdraw transection deleted successfully.');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Some thing is wrong..!');
        }
    }

    public function transectionDipsoti($id){
        try{
            $company = Company::first();
            $transection = BankTransectionDetail::with(['bank','user'])->findOrFail($id);            
            return view('bank.transection-details-view', compact('company','transection'));
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Some thing is wrong..!');
        }
    }

    public function bankToBankView(){
        $company = Company::first();
        $banks = BankDetail::get();
        $transections = BankTransectionDetail::with(['bank','user'])->where('date', Carbon::today())->paginate(15);
        return view('bank.bank-to-bank-transection', compact('company','banks','transections'));
    }

    public function bankToBank(Request $request){
        try{
            $validated = $request->validate([
                'from_bank_id' => ['required', 'integer', 'exists:bank_details,id', 'different:to_bank_id'],
                'to_bank_id'   => ['required', 'integer', 'exists:bank_details,id'],
                'amount'       => ['required', 'numeric', 'min:1'],
                'remarks'      => ['nullable', 'string', 'max:255'],
            ], [
                'from_bank_id.required' => 'Please select From bank.',
                'to_bank_id.required'   => 'Please select To bank.',
                'from_bank_id.different'=> 'From & To bank are not same.',
            ]);

            $date = Carbon::today();

            $userId = Auth::guard('admin')->id();

            // Get From Bank Current Balance
            $fromBankBalance = BankTransectionDetail::where('bank_id', $request->from_bank_id)
                                ->selectRaw("
                                    SUM(CASE WHEN status='Deposit' THEN amount ELSE 0 END) -
                                    SUM(CASE WHEN status='Withdraw' THEN amount ELSE 0 END)
                                    AS balance
                                ")->value('balance');

            $fromBankBalance = $fromBankBalance ?? 0;

            // Check Enough Balance
            if ($request->amount > $fromBankBalance) {
                return back()->with('error', 'Not enough balance! Available balance: ' . number_format($fromBankBalance, 2));
            }

            // Withdraw from From Bank
            $withdraw = new BankTransectionDetail();
            $withdraw->bank_id   = $request->from_bank_id;
            $withdraw->user_id   = $userId;
            $withdraw->amount    = $request->amount;
            $withdraw->date      = $date;
            $withdraw->status    = 'Withdraw';
            $withdraw->remarks   = 'Transfer to Bank ID: ' . $request->to_bank_id . '. ' . ($request->remarks ?? '');
            $withdraw->save();

            // Deposit to To Bank
            $deposit = new BankTransectionDetail();
            $deposit->bank_id   = $request->to_bank_id;
            $deposit->user_id   = $userId;
            $deposit->amount    = $request->amount;
            $deposit->date      = $date;
            $deposit->status    = 'Deposit';
            $deposit->remarks   = 'Transfer from Bank ID: ' . $request->from_bank_id . '. ' . ($request->remarks ?? '');
            $deposit->save();

            return redirect()->route('bank.transection')->with('success', 'Bank to Bank transfer successful!');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Some thing is wrong..!');
        }
    }

    public function deleteTransection($id){
        try{
            $transections = BankTransectionDetail::findOrFail($id);
            // $transections->delete();
            return redirect()->back()->with('success', 'Transection deleted successfully.');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Some thing is wrong..!');
        }
    }
}
