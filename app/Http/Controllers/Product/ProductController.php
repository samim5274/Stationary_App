<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

use App\Models\Company;
use App\Models\Product;
use App\Models\PdrCategory;
use App\Models\PdrSubCategory;
use App\Models\PdrStock;

class ProductController extends Controller
{
    public function index(){
        $company = Company::first();
        $products = Product::with('category', 'subcategory')->paginate(15);
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
        
        // Validation and creation logic here
        $request->validate([
            'name'           => ['required','string','max:255'],
            'sku'            => ['nullable','string','max:100', Rule::unique('products','sku')],
            'unit'           => ['nullable','string', Rule::in(['pcs','box','pack','dozen','g','kg','ton','ml','l','ft','m'])],

            'price'          => ['required','numeric','min:0'],
            'discount'       => ['nullable','numeric','min:0'],
            'qty'            => ['nullable','integer','min:0'],
            'min_stock'      => ['nullable','integer','min:0'],

            'category_id'    => ['nullable','integer', Rule::exists('categories','id')],
            'subcategory_id' => ['nullable','integer', Rule::exists('subcategories','id')],

            'description'    => ['nullable','string','max:2000'],
            'status'         => ['nullable','boolean'],

            'image'          => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'], // 2MB
        ]);

        // ✅ Subcategory belongs to selected category (important)
        if (!empty($validated['subcategory_id'])) {
            $ok = Subcategory::where('id', $validated['subcategory_id'])
                ->when(!empty($validated['category_id']), fn($q) => $q->where('category_id', $validated['category_id']))
                ->exists();

            if (!$ok) {
                return back()
                    ->withErrors(['subcategory_id' => 'Selected subcategory does not match the selected category.'])
                    ->withInput();
            }
        }

        // ✅ status checkbox: checked হলে 1, না হলে 0
        $validated['status'] = $request->has('status') ? 1 : 0;

        // ✅ SKU auto-generate if empty
        if (empty($validated['sku'])) {
            $validated['sku'] = $this->generateSku($validated['name']);
        }

        // ✅ image upload
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $name = 'p_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();

            // storage/app/public/products
            $file->storeAs('public/products', $name);

            $validated['image'] = $name;
        }

        Product::create($validated);

        return redirect()->route('product.list')->with('success', 'Product created successfully!');

    }
}
