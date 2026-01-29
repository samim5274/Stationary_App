<?php

namespace App\Http\Controllers\Expenses;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

use App\Models\Company;
use App\Models\Excategory;
use App\Models\Exsubcategory;
use App\Models\Expenses;


class ExpensesController extends Controller
{
    public function index(){
        $company = Company::first();
        $expensess = Expenses::where('date', Carbon::today())->paginate(5);
        $categories = Excategory::get();
        $subcategories = Exsubcategory::get();
        return view('expenses.expenses-details', compact('company','expensess','categories', 'subcategories'));
    }

    public function getSubCategory($id) {
        $subcategories = Exsubcategory::where('category_id', $id)->get();
        return response()->json($subcategories);
    }

    public function create(Request $request){
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:excategories,id',
            'subcategory_id' => 'required|exists:exsubcategories,id',
            'amount' => 'required|numeric|min:1',
            'description' => 'nullable|string|max:1000',
        ]);

        try{
            $data = new Expenses();
            $data->title = $request->title;
            $data->category_id = $request->category_id;
            $data->subcategory_id = $request->subcategory_id;
            $data->user_id = Auth::guard('admin')->user()->id;
            $data->amount = $request->amount;
            $data->date = Carbon::now()->format('Y-m-d');
            $data->remark = $request->description;
            $data->save();

            return redirect()->back()->with('success', 'Expense added successfully!');
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Some thing is wrong..!');
        } 
    }

    public function viewDetials($id){
        $company = Company::first();
        $expenses = Expenses::findOrFail($id);
        return view('expenses.expenses-details-view', compact('company','expenses'));
    }

    public function delete($id){
        try{
            $expenses = Expenses::findOrFail($id);
            $expenses->delete();
            return redirect()->route('expenses')->with('success', 'Expenses delete successfully.');
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Some thing is wrong..!');
        }
    }

    public function printExpenses($id){
        $company = Company::first();
        $expense = Expenses::findOrFail($id);
        return view('report.print.print-expenses', compact('company','expense'));
    }

    public function setting(){
        $company = Company::first();
        $categories = Excategory::paginate(15);
        $subcategories = Exsubcategory::paginate(15);
        return view('expenses.expenses-setting', compact('company','categories', 'subcategories'));
    }

    public function createView(){
        $company = Company::first();
        return view('expenses.create-category', compact('company'));
    }

    public function createCategory(Request $request){
        try{
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255', 'unique:excategories,name'],
            ]);

            Excategory::create([ 'name' => $validated['name'], ]);

            return redirect()->route('expenses.setting')->with('success', 'Category created successfully!');
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Some this is wrong..!');
        }
    }

    public function updateCategory($id){
        $company = Company::first();
        $excategory = Excategory::where('id',$id)->first();
        return view('expenses.create-category', compact('company','excategory'));
    }

    public function modifyCategory(Request $request, $id)
    {
        $excategory = Excategory::findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:excategories,name,' . $excategory->id],
        ]);

        $excategory->update($validated);

        return redirect()->route('expenses.setting')->with('success', 'Category updated successfully!');
    }

    public function deleteCategory($id){
        try{
            Excategory::where('id', $id)->delete();

            return redirect()->route('expenses.setting')->with('success', 'Category deleted successfully!');
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Some this is wrong..!');
        }
    }

}
