<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Models\Company;
use App\Models\Product;
use App\Models\PdrCategory;
use App\Models\PdrSubCategory;
use App\Models\PdrStock;

class ProductController extends Controller
{
    public function index(Request $request){
        $company = Company::first();
        // $products = Product::with('category', 'subcategory')->paginate(100);
        $q = trim($request->q);

        $products = Product::query()
            ->with(['category','subcategory'])
            ->when($q, function ($query) use ($q) {
                $query->where(function($qq) use ($q){
                    $qq->where('name', 'like', "%{$q}%")
                    ->orWhere('sku', 'like', "%{$q}%")
                    ->orWhereHas('category', fn($c) => $c->where('name', 'like', "%{$q}%"))
                    ->orWhereHas('subcategory', fn($s) => $s->where('name', 'like', "%{$q}%"));
                });
            })->latest()->paginate(15)->appends(['q' => $q]);

        return view('product.product-list', compact('products', 'company'));
    }

    public function createView(){
        $company = Company::first();
        $categories = PdrCategory::all();
        $subcategories = PdrSubCategory::all();
        return view('product.product-create', compact('company', 'categories', 'subcategories'));
    }

    public function getSubcategory($id)
    {
        $subCategory = PdrSubCategory::where('category_id', $id)
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        return response()->json(['subCategory' => $subCategory]);
    }

    private function generateSku(string $name): string
    {
        $base = strtoupper(Str::slug($name, ''));
        $base = substr($base, 0, 8);
        $sku  = $base . '-' . rand(1000, 9999);

        while (Product::where('sku', $sku)->exists()) {
            $sku = $base . '-' . rand(1000, 9999);
        }
        return $sku;
    }

    public function create(Request $request){
        try {
            // Validation and creation logic here
            $validated = $request->validate([
                'name'           => ['required','string','max:255'],
                'sku'            => ['nullable','string','max:100', Rule::unique('products','sku')],
                'unit'           => ['required','string', Rule::in(['pcs','box','pack','dozen','g','kg','ton','ml','l','ft','m'])],

                'price'          => ['required','numeric','min:0'],
                'discount'       => ['nullable','numeric','min:0'],
                'stock'          => ['nullable','integer','min:0'],
                'min_stock'      => ['nullable','integer','min:0'],

                'category_id'    => ['required','integer', Rule::exists('pdr_categories','id')],
                'subcategory_id' => ['required','integer', Rule::exists('pdr_sub_categories','id')],

                'description'    => ['nullable','string','max:2000'],
                'status'         => ['nullable','boolean'],

                'image'          => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'],
            ]);

            
            // Subcategory belongs to selected category (important)
            if (!empty($validated['subcategory_id'])) {
                $ok = PdrSubCategory::where('id', $validated['subcategory_id'])
                    ->when(!empty($validated['category_id']), fn($q) => $q->where('category_id', $validated['category_id']))
                    ->exists();

                if (!$ok) {
                    return back()
                        ->withErrors(['subcategory_id' => 'Selected subcategory does not match the selected category.'])
                        ->withInput();
                }
            }

            // status checkbox: checked then 1, or 0
            $validated['status'] = $request->has('status') ? 1 : 0;

            // SKU auto-generate if empty
            if (empty($validated['sku'])) {
                $validated['sku'] = $this->generateSku($validated['name']);
            }

            // image upload
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $name = 'pdr_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();

                // storage/app/products
                $file->storeAs('products', $name);

                $validated['image'] = $name;
            }

            $product = null;

            DB::transaction(function () use ($validated, & $product) {
                // Product create
                $product = Product::create($validated);

                // Opening stock insert (stock null then 0)
                $openingQty = (int) ($validated['stock'] ?? 0);

                // if stock 0 then stock row not created
                if ($openingQty <= 0) return;

                PdrStock::create([
                    'product_id' => $product->id,
                    'ref'        => 'OPEN-' . now()->format('YmdHis') . '-' . Str::upper(Str::random(4)),
                    'date'       => Carbon::today()->toDateString(),
                    'type'       => 'IN', // opening stock = IN
                    'qty'        => $openingQty,
                    'remark'     => 'Opening stock added at product create',
                    'created_by' => Auth::guard('admin')->user()->id, 
                ]);
            });

            return redirect()->route('product.list')->with('success', 'Product created successfully!');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('product.list')->with('error', 'Something is wrong. Please try again..!');
        } catch (\Throwable $e) {
            return redirect()->route('product.list')->with('error', 'Something is wrong. Please try again..!');
        }
    }

    public function delete($id){
        try {
            $product = Product::findOrFail($id);

            if (PdrStock::where('product_id', $product->id)->exists()) {
                return redirect()->route('product.list')
                    ->with('error', 'This product has stock history. Delete not allowed.');
            }

            if ($product->image && Storage::disk('public')->exists('products/'.$product->image)) {
                Storage::disk('public')->delete('products/'.$product->image);
            }

            $product->delete();

            return redirect()->route('product.list')->with('success', 'Product deleted successfully!');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('product.list')->with('error', 'Product not found.');
        } catch (\Throwable $e) {
            return redirect()->route('product.list')->with('error', 'Something went wrong while deleting the product.');
        }
    }

    public function edit($id, $sku, $slug){
        try {
            $company = Company::first();
            $product = Product::findOrFail($id);
            $categories = PdrCategory::all();
            $subcategories = PdrSubCategory::all();
            return view('product.product-edit', compact('company', 'product', 'categories', 'subcategories'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('product.list')->with('error', 'Product not found.');
        }
    }

    public function modify(Request $request, $id)
    {
        try {
            $product = Product::findOrFail($id);

            $validated = $request->validate([
                'name'           => ['required','string','max:255'],
                'sku'            => ['nullable','string','max:100', Rule::unique('products','sku')->ignore($product->id)],
                'unit'           => ['required','string', Rule::in(['pcs','box','pack','dozen','g','kg','ton','ml','l','ft','m'])],

                'price'          => ['required','numeric','min:0'],
                'discount'       => ['nullable','numeric','min:0'],
                'stock'          => ['nullable','integer','min:0'],
                'min_stock'      => ['nullable','integer','min:0'],

                'category_id'    => ['required','integer', Rule::exists('pdr_categories','id')],
                'subcategory_id' => ['required','integer', Rule::exists('pdr_sub_categories','id')],

                'description'    => ['nullable','string','max:2000'],
                'status'         => ['nullable','boolean'],
                'image'          => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'],
            ]);

            // subcategory belongs to category check
            $ok = PdrSubCategory::where('id', $validated['subcategory_id'])
                ->where('category_id', $validated['category_id'])
                ->exists();

            if (!$ok) {
                return back()
                    ->withErrors(['subcategory_id' => 'Selected subcategory does not match the selected category.'])
                    ->withInput();
            }

            // checkbox status
            $validated['status'] = $request->has('status') ? 1 : 0;

            // SKU auto-generate if empty (optional)
            if (empty($validated['sku'])) {
                $validated['sku'] = $this->generateSku($validated['name']);
            }

            DB::transaction(function () use ($request, $validated, $product) {

                // ✅ Stock adjust logic (difference based)
                $oldStock = (int) ($product->stock ?? 0);
                $newStock = (int) ($validated['stock'] ?? 0);
                $diff     = $newStock - $oldStock;

                // ✅ Image upload (replace + delete old)
                if ($request->hasFile('image')) {
                    $file = $request->file('image');
                    $name = 'pdr_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();

                    $file->storeAs('public/products', $name);

                    // delete old file (if exists)
                    if ($product->image && Storage::disk('public')->exists('products/'.$product->image)) {
                        Storage::disk('public')->delete('products/'.$product->image);
                    }

                    $validated['image'] = $name;
                }

                // ✅ Update product
                $product->update($validated);

                // ✅ Stock change হলে stock table এ record
                if ($diff !== 0) {
                    PdrStock::create([
                        'product_id' => $product->id,
                        'ref'        => 'ADJ-' . now()->format('YmdHis') . '-' . Str::upper(Str::random(4)),
                        'date'       => Carbon::today()->toDateString(),
                        'type'       => $diff > 0 ? 'IN' : 'OUT',      // increase = IN, decrease = OUT
                        'qty'        => abs($diff),
                        'remark'     => 'Stock adjusted from edit',
                        'created_by' => optional(Auth::guard('admin')->user())->id,
                    ]);
                }
            });

            return redirect()->route('product.list')->with('success', 'Product updated successfully!');

        } catch (\Throwable $e) {
            // optional: \Log::error($e);
            return redirect()->route('product.list')->with('error', 'Something is wrong. Please try again..!');
        }
    }

    public function categoryIndex(){
        try {
            $company = Company::first();
            $categories = PdrCategory::latest()->paginate(50);
            return view('product.category.category-list', compact('company', 'categories'));
        } catch (\Throwable $e) {
            return redirect()->route('product.list')->with('error', 'Something is wrong. Please try again..!');
        }
    }

    public function categoryCreate(Request $request){
        try {
            $validated = $request->validate([
                'name' => ['required','string','max:255','unique:pdr_categories,name'],
            ]);
            PdrCategory::create($validated);
            return redirect()->route('category.list')->with('success', 'Category created successfully!');
        } catch (\Throwable $e) {
            return redirect()->route('category.list')->with('error', 'Something is wrong. Please try again..!');
        }
    }

    public function categoryEdit($id){
        try {
            $company = Company::first();
            $category = PdrCategory::findOrFail($id);
            return view('product.category.category-edit', compact('company', 'category'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('category.list')->with('error', 'Category not found.');
        }
    }

    public function categoryModify(Request $request, $id){
        try {
            $category = PdrCategory::findOrFail($id);
            $validated = $request->validate([
                'name' => ['required','string','max:255', Rule::unique('pdr_categories','name')->ignore($category->id)],
            ]);
            $category->update($validated);
            return redirect()->route('category.list')->with('success', 'Category updated successfully!');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('category.list')->with('error', 'Category not found.');
        } catch (\Throwable $e) {
            return redirect()->route('category.list')->with('error', 'Something is wrong. Please try again..!');
        }
    }

    public function categoryDelete($id){
        try {
            $category = PdrCategory::findOrFail($id);
            $category->delete();
            return redirect()->route('category.list')->with('success', 'Category deleted successfully!');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('category.list')->with('error', 'Category not found.');
        } catch (\Throwable $e) {
            return redirect()->route('category.list')->with('error', 'Something went wrong while deleting the category.');
        }
    }

    public function subcategoryIndex(){
        try {
            $company = Company::first();
            $categories = PdrCategory::latest()->get();
            $subcategories = PdrSubCategory::with('category')->latest()->paginate(50);
            return view('product.subcategory.subcategory-list', compact('company', 'subcategories', 'categories'));
        } catch (\Throwable $e) {
            return redirect()->route('product.list')->with('error', 'Something is wrong. Please try again..!');
        }
    }

    public function subcategoryCreate(Request $request){
        try {
            $validated = $request->validate([
                'name' => ['required','string','max:255'],
                'category_id' => ['required','integer', Rule::exists('pdr_categories','id')],
            ]);
            PdrSubCategory::create($validated);
            return redirect()->route('subcategory.list')->with('success', 'Sub-category created successfully!');
        } catch (\Throwable $e) {
            return redirect()->route('subcategory.list')->with('error', 'Something is wrong. Please try again..!');
        }
    }

    public function subcategoryDelete($id){
        try {
            $subcategory = PdrSubCategory::findOrFail($id);
            $subcategory->delete();
            return redirect()->route('subcategory.list')->with('success', 'Sub-category deleted successfully!');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('subcategory.list')->with('error', 'Sub-category not found.');
        } catch (\Throwable $e) {
            return redirect()->route('subcategory.list')->with('error', 'Something went wrong while deleting the sub-category.');
        }
    }

    public function subcategoryEdit($id){
        try {
            $company = Company::first();
            $categories = PdrCategory::all();
            $subcategory = PdrSubCategory::findOrFail($id);
            return view('product.subcategory.subcategory-edit', compact('company', 'subcategory', 'categories'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('subcategory.list')->with('error', 'Sub-category not found.');
        }
    }

    public function subcategoryModify(Request $request, $id){
        try {
            $subcategory = PdrSubCategory::findOrFail($id);
            $validated = $request->validate([
                'name' => ['required','string','max:255'],
                'category_id' => ['required','integer', Rule::exists('pdr_categories','id')],
            ]);
            $subcategory->update($validated);
            return redirect()->route('subcategory.list')->with('success', 'Sub-category updated successfully!');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('subcategory.list')->with('error', 'Sub-category not found.');
        } catch (\Throwable $e) {
            return redirect()->route('subcategory.list')->with('error', 'Something is wrong. Please try again..!');
        }
    }
}
