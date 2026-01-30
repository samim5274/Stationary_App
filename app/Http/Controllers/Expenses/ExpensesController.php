<?php

namespace App\Http\Controllers\Expenses;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Models\Company;
use App\Models\Excategory;
use App\Models\Exsubcategory;
use App\Models\Expenses;


class ExpensesController extends Controller
{
    public function index(){
        $company = Company::first();
        $expensess = Expenses::with(['category','subcategory','user'])->where('date', Carbon::today())->latest()->paginate(5);
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
        } catch (\Throwable $e) {
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
        } catch (\Throwable $e) {
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
        $categories = Excategory::orderBy('name')->paginate(15, ['*'], 'cat_page');
        $subcategories = Exsubcategory::with('category')->orderBy('name')->paginate(15, ['*'], 'sub_page');
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
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Some this is wrong..!');
        }
    }

    public function updateCategory($id){
        $company = Company::first();
        $excategory = Excategory::findOrFail($id);
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
            $cat = Excategory::withCount(['subcategories','expenses'])->findOrFail($id);

            if ($cat->subcategories_count > 0 || $cat->expenses_count > 0) {
                return back()->with('error', 'Cannot delete: category has subcategories/expenses.');
            }

            $cat->delete();

            return redirect()->route('expenses.setting')->with('success', 'Category deleted successfully!');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Some this is wrong..!');
        }
    }

    public function createSubView(){
        $company = Company::first();
        $categories = Excategory::get();
        return view('expenses.create-sub-category', compact('company', 'categories'));
    }

    public function storeSubCategory(Request $request){
        try{
            $validated = $request->validate(
                [
                    'category_id' => ['required', 'integer', 'exists:excategories,id'],
                    'name' => [
                        'required',
                        'string',
                        'max:255',
                        Rule::unique('exsubcategories', 'name')
                            ->where(fn ($q) => $q->where('category_id', $request->category_id)),
                    ],
                ],
                [
                    'category_id.required' => 'Please select a category.',
                    'category_id.exists'   => 'Selected category is invalid.',
                    'name.required'        => 'Subcategory name is required.',
                    'name.unique'          => 'This subcategory already exists under the selected category.',
                ]
            );

            Exsubcategory::create($validated);

            return redirect()->route('expenses.setting')->with('success', 'Subcategory created successfully!');
        } catch(\Throwable $e) {
            return redirect()->back()->with('error', 'Some this is wrong..!');
        }
    }

    public function updateSubCategory($id){
        $company = Company::first();
        $categories = Excategory::get();
        $exsubcategory = Exsubcategory::findOrFail($id);
        return view('expenses.create-sub-category', compact('company', 'categories','exsubcategory'));
    }

    public function modifySubCategory(Request $request, $id){
        try{
            $exsubcategory = Exsubcategory::findOrFail($id);

            $validated = $request->validate([
                'category_id' => ['required', 'integer', 'exists:excategories,id'],
                'name' => [
                    'required','string','max:255',
                    Rule::unique('exsubcategories', 'name')
                        ->where(fn($q) => $q->where('category_id', $request->category_id))
                        ->ignore($exsubcategory->id),
                ],
            ]);

            $exsubcategory->update($validated);

            return redirect()->route('expenses.setting')->with('success', 'Subcategory updated successfully!');
        } catch(\Throwable $e) {
            return redirect()->back()->with('error', 'Some this is wrong..!');
        }
    }

    public function deleteSubCategory($id){
        try{
            $sub = Exsubcategory::withCount('expenses')->findOrFail($id);

            if ($sub->expenses_count > 0) {
                return back()->with('error', 'Cannot delete: subcategory has expenses.');
            }

            $sub->delete();
            return redirect()->route('expenses.setting')->with('success', 'Sub-Category deleted successfully!');
        } catch(\Throwable $e) {
            return redirect()->back()->with('error', 'Some this is wrong..!');
        }
    }

}
