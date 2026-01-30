<?php

namespace App\Http\Controllers\Income;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Models\Company;
use App\Models\Income;
use App\Models\IncomeCategory;
use App\Models\IncomeSubCategory;

class IncomeController extends Controller
{
    public function index(){
        $company = Company::first();
        $incomes = Income::with(['category','subcategory','user'])->where('income_date', Carbon::today())->get();
        $categories = IncomeCategory::get();
        $subcategories = IncomeSubCategory::get();
        return view('income.income-details', compact(
            'company','incomes',
            'categories','subcategories',
        ));
    }

    public function getSubCategory($id){
        $subcategories = IncomeSubCategory::where('category_id', $id)->get();
        return response()->json($subcategories);
    }

    public function create(Request $request){
        try{
            $data = $request->validate([
                'title'          => ['required', 'string', 'max:255'],
                'category_id'    => ['required', 'exists:income_categories,id'],
                'subcategory_id' => ['required', 'exists:income_sub_categories,id'],
                'description'    => ['nullable', 'string'],
                'amount'         => ['required', 'numeric', 'min:0'],
                'income_date'    => ['nullable', 'date'],
            ]);

            $isValidPair = IncomeSubCategory::where('id', $data['subcategory_id'])->where('category_id', $data['category_id'])->exists();

            if (!$isValidPair) {
                return back()->withErrors(['subcategory_id' => 'Selected sub category does not belong to the selected category.'])->withInput();
            }

            $data['user_id'] = Auth::guard('admin')->id();
            $data['income_date'] = $data['income_date'] ?? now()->toDateString();

            Income::create($data);

            return redirect()->back()->with('success', 'Income added successfully.');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Some thing is wrong..!');
        }
    }

    public function viewDetails($id){
        $company = Company::first();
        $incomes = Income::with(['category','subcategory','user'])->findOrFail($id);

        return view('income.income-view-details', compact(
            'company','incomes',
        ));
    }

    public function delete($id){
        try{
            $income = Income::findOrFail($id);
            $income->delete();
            return redirect()->route('incomes')->with('success', 'Expenses delete successfully.');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Some thing is wrong..!');
        }
    }

    public function printIncome($id){
        try{
            $company = Company::first();
            $income = Income::findOrFail($id);
            return view('report.print.print-income', compact('company','income'));
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Some thing is wrong..!');
        }
    }

    public function setting(){
        $company = Company::first();
        $incomes = Income::with(['category','subcategory','user'])->get();
        $categories = IncomeCategory::get();
        $subcategories = IncomeSubCategory::get();
        return view('income.income-setting', compact(
            'company','incomes',
            'categories','subcategories',
        ));
    }

    public function createView(){
        $company = Company::first();
        return view('income.create-category', compact('company'));
    }

    public function createCategory(Request $request){
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:income_categories,name'],
        ]);

        IncomeCategory::create($data);

        return redirect()->route('income.setting')->with('success', 'Income category created successfully.');
    }

    public function updateCategory($id){
        $company = Company::first();
        $incomeCategory = IncomeCategory::findOrFail($id);
        return view('income.create-category', compact('company','incomeCategory'));    
    }

    public function modifyCategory(Request $request, $id){
        try{
            $incomeCategory = IncomeCategory::findOrFail($id);

            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255', 'unique:income_categories,name,' . $incomeCategory->id],
            ]);
            
            $incomeCategory->update($validated);

            return redirect()->route('income.setting')->with('success', 'Category updated successfully!');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Some thing is wrong..!');
        }
    }

    public function deleteCategory($id){
        try{
            $cat = IncomeCategory::findOrFail($id);
            $cat->delete();
            return redirect()->route('income.setting')->with('success', 'Category deleted successfully!');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Some thing is wrong..!');
        }
    }

    public function createSubView(){
        $company = Company::first();
        $categories = IncomeCategory::get();
        return view('income.create-sub-category', compact('company','categories'));
    }

    public function storeSubCategory(Request $request){
        try {
            $validated = $request->validate(
                [
                    'category_id' => ['required', 'integer', 'exists:income_categories,id'],
                    'name' => [
                        'required',
                        'string',
                        'max:255',
                        Rule::unique('income_sub_categories', 'name')->where(fn ($q) => $q->where('category_id', $request->category_id)),
                    ],
                ],
                [
                    'category_id.required' => 'Please select a category.',
                    'category_id.exists'   => 'Selected category is invalid.',
                    'name.required'        => 'Subcategory name is required.',
                    'name.unique'          => 'This subcategory already exists under the selected category.',
                ]
            );

            IncomeSubCategory::create($validated);

            return redirect()->route('income.setting')->with('success', 'Income subcategory created successfully!');
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->with('error', 'Something is wrong..!');
        }
    }

    public function updateSubCategory($id){
        $company = Company::first();
        $categories = IncomeCategory::get();
        $incomesubcategory = IncomeSubCategory::findOrFail($id);
        return view('income.create-sub-category', compact('company', 'categories','incomesubcategory'));
    }

    public function modifySubCategory(Request $request, $id){
        try{
            $incomesubcategory = IncomeSubCategory::findOrFail($id);

            $validated = $request->validate([
                'category_id' => ['required', 'integer', 'exists:income_categories,id'],
                'name' => [
                    'required','string','max:255',
                    Rule::unique('income_sub_categories', 'name')
                        ->where(fn($q) => $q->where('category_id', $request->category_id))
                        ->ignore($incomesubcategory->id),
                ],
            ]);

            $incomesubcategory->update($validated);

            return redirect()->route('income.setting')->with('success', 'Subcategory updated successfully!');
        } catch(\Throwable $e) {
            return redirect()->back()->with('error', 'Some this is wrong..!');
        }
    }

    public function deleteSubCategory($id){
        try{
            $sub = IncomeSubCategory::findOrFail($id);            
            $sub->delete();
            return redirect()->route('income.setting')->with('success', 'Sub-Category deleted successfully!');
        } catch(\Throwable $e) {
            return redirect()->back()->with('error', 'Some this is wrong..!');
        }
    }
}
