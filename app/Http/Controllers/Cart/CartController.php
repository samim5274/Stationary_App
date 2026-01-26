<?php

namespace App\Http\Controllers\Cart;

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

class CartController extends Controller
{
    function generateRegNum() {
        $userId = Auth::guard('admin')->user()->id;
        $order = Order::where('user_id', $userId)->count() + 1;
        return '1' . str_pad($userId, 4, '0', STR_PAD_LEFT) . str_pad($order, 8, '0', STR_PAD_LEFT);
    }

    public function cart()
    {
        $company = Company::first();
        $reg = $this->generateRegNum();
        $payMathod = PaymentMethod::all();
        $cart = Cart::with('product')->where('reg', $reg)->get();
        $count = Cart::where('reg', $reg)->count();
        return view('cart.cart-view', compact('company', 'reg', 'payMathod', 'cart', 'count'));
    }

    public function addCart(Request $request)
    {
        try{
            $id = $request->input('search', '');
            $cart = new Cart();
            $stock = new PdrStock();
            $userId = Auth::guard('admin')->id();

            $search = trim($id);
            $words = preg_split('/\s+/', $search);
            $product = Product::where(function ($q) use ($words, $search) {
                    
                    if (is_numeric($search)) { $q->orWhere('id', $search); }

                    foreach ($words as $word) {
                        $q->orWhere('name', 'LIKE', "%{$word}%")
                        ->orWhere('slug', 'LIKE', "%{$word}%")
                        ->orWhere('sku', 'LIKE', "%{$word}%");
                    }
                })->first();
            
            if(empty($product) || $product->availability == 0) {
                return redirect()->back()->with('error','This item not availabel righ now');
            }

            if(!is_null($product->stock) && $product->stock < 1) {
                return redirect()->back()->with('warning','Sorry 😞 This item stock not availabel righ now. Try to another. Thank You!');
            }
            
            if($product->expired_at < Carbon::today()){
                return redirect()->back()->with('warning','Sorry 😞 This item is expried. Try to another. Thank You!');
            }
            
            $reg = $this->generateRegNum();
            
            $findData = Cart::where('reg', $reg)->where('product_id', $product->id)->first();
            $findStock = PdrStock::where('ref', $reg)->where('product_id', $product->id)->first();
            
            if($findData) {
                $findData->quantity += 1;
                $findData->update();
                $findStock->qty += 1;
                $findStock->update();
                $product->stock -= 1;
                $product->update();
                return redirect()->back();
            }

            $cart->reg = $reg;
            $cart->date = Carbon::now()->toDateString();
            $cart->user_id = $userId;
            $cart->product_id = $product->id;
            $cart->price = $product->price;

            $stock->ref = $reg;
            $stock->date = Carbon::now()->toDateString();
            $stock->product_id = $product->id;
            $stock->type = 'OUT';
            $stock->qty += 1;
            $stock->remark = 'Sale Out';
            $stock->created_by = $userId;


            $product->stock -= 1;

            // dd($cart, $stock, $product);
            $product->update();
            $stock->save();
            $cart->save();
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong. ' . $e->getMessage());
        }
    }

    public function updateQty(Request $request)
    {
        try{
            $request->validate([
                'id'       => ['required','exists:carts,id'],
                'quantity' => ['required','integer','min:1'],
            ]);

            $newQty = (int) $request->quantity;
            $userId = Auth::guard('admin')->id() ?? Auth::id() ?? 1;

            return DB::transaction(function () use ($request, $newQty, $userId) {

                $cart = Cart::lockForUpdate()->findOrFail($request->id);
                $product = Product::lockForUpdate()->findOrFail($cart->product_id);

                $availableStock = (int) $product->stock + (int) $cart->quantity;

                if ($newQty > $availableStock) {
                    return response()->json(['status' => 'error', 'message' => 'Stock not available'], 422);
                }

                $oldQty = (int) $cart->quantity;
                $diff   = $newQty - $oldQty;

                // ✅ pdr_stocks row find: product_id + ref(reg) + type OUT
                $stock = PdrStock::lockForUpdate()
                    ->where('product_id', $cart->product_id)
                    ->where('ref', $cart->reg)
                    ->where('type', 'OUT')
                    ->first();

                // if missing create 0 qty
                if (!$stock) {
                    $stock = PdrStock::create([
                        'product_id' => $cart->product_id,
                        'ref'        => $cart->reg,
                        'date'       => Carbon::now()->toDateString(),
                        'type'       => 'OUT',
                        'qty'        => 0,
                        'remark'     => 'Cart OUT',
                        'created_by' => $userId,
                    ]);
                }

                // adjust OUT qty
                if ($diff > 0) {
                    $stock->qty += $diff;
                } elseif ($diff < 0) {
                    $adjust = abs($diff);
                    if ($stock->qty < $adjust) {
                        return response()->json(['status' => 'error', 'message' => 'Cannot reduce stock below 0'], 422);
                    }
                    $stock->qty -= $adjust;
                }

                $stock->date = Carbon::now()->toDateString();
                $stock->remark = 'Cart qty changed';
                $stock->created_by = $userId;
                $stock->save();

                // product stock update: stock -= diff
                $product->stock = (int) $product->stock - $diff;
                $product->save();

                // cart qty update
                $cart->quantity = $newQty;
                $cart->save();

                return response()->json([
                    'status'   => 'success',
                    'quantity' => $cart->quantity,
                    'stock'    => $product->stock,
                ]);
            });
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Something went wrong. ' . $e->getMessage()], 500);
        }
    }

    public function removeToCart($product_id, $reg)
    {
        try{
            $userId = Auth::guard('admin')->id();
            $cart = Cart::where('reg', $reg)->where('product_id', $product_id)->first();
            if(!$cart) {
                return redirect()->back()->with('error','Item not found in cart');
            }
            $product = Product::where('id', $product_id)->first();

            $stock = PdrStock::where('ref', $reg)
                            ->where('product_id', $product_id)
                            ->where('type', 'OUT')
                            ->first();

            if($stock) {
                $product->stock += $stock->qty;
                $product->update();
                $stock->delete();
            }

            $cart->delete();
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong. ' . $e->getMessage());
        }
    }

}
