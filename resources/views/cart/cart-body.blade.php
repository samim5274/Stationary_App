<!-- LEFT : col-8 -->
<div class="col-span-12 md:col-span-8">
    <div class="p-5 bg-white rounded-lg shadow-xs dark:bg-gray-800">

        <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">
            Cart
        </h4>

        <!-- Search Bar -->
        <form action="{{ route('add.cart') }}" method="GET">
            @csrf
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </span>

                <input
                    id="cartSearch"
                    type="text"
                    autofocus
                    name="search"
                    placeholder="Search product by name / SKU..."
                    class="w-full pl-10 pr-4 py-2 text-sm border rounded-lg
                        bg-gray-50 dark:bg-gray-700
                        border-gray-200 dark:border-gray-600
                        text-gray-700 dark:text-gray-200
                        focus:border-purple-500 focus:ring-2 focus:ring-purple-200
                        dark:focus:ring-purple-900 focus:outline-none"/>
            </div>
        </form>
        

        <!-- Cart Table -->
        <div class="mt-6 rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-sm overflow-hidden">

            <!-- Header -->
            <div class="px-5 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100">Cart Items</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400">
                        Review items, update quantity, and confirm checkout.
                    </p>
                </div>

                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                            bg-emerald-100 text-emerald-800 border border-emerald-200
                            dark:bg-emerald-800 dark:text-white dark:border-emerald-700">
                    {{ $cart->count() }} items
                </span>

            </div>

            <!-- Table -->
            <div class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 overflow-hidden">
                <div class="max-h-[835px] overflow-y-auto">
                    <table class="min-w-full text-sm">
                        <!-- Head -->
                        <thead class="bg-gray-100 dark:bg-gray-800">
                            <tr class="text-left">
                                <th class="px-5 py-3 font-semibold text-gray-700 dark:text-gray-200">
                                    Product
                                </th>
                                <th class="px-5 py-3 font-semibold text-gray-700 dark:text-gray-200 whitespace-nowrap">
                                    Price
                                </th>
                                <th class="px-5 py-3 font-semibold text-gray-700 dark:text-gray-200">
                                    Qty
                                </th>
                                <th class="px-5 py-3 font-semibold text-gray-700 dark:text-gray-200 whitespace-nowrap">
                                    Subtotal
                                </th>
                                <th class="px-5 py-3 w-12"></th>
                            </tr>
                        </thead>

                        <!-- Body -->
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700
                                    bg-white dark:bg-gray-900
                                    text-gray-800 dark:text-gray-200">

                            @if($cart->isEmpty())
                                <tr>
                                    <td colspan="5" class="px-5 py-12 text-center">
                                        <div class="inline-flex flex-col items-center gap-3">
                                            <div class="w-14 h-14 rounded-2xl
                                                        bg-gray-100 dark:bg-gray-800
                                                        flex items-center justify-center">
                                                <i class="fa-solid fa-cart-shopping
                                                        text-gray-500 dark:text-gray-300 text-lg"></i>
                                            </div>
                                            <p class="font-semibold text-gray-800 dark:text-gray-100">
                                                Your cart is empty
                                            </p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                Search products and add them to cart.
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endif

                            @foreach($cart as $item)
                                <tr class="transition bg-white dark:bg-gray-900 hover:bg-gray-50 dark:hover:bg-gray-800" data-cart-row="1">

                                    <!-- Product -->
                                    <td class="px-5 py-4">
                                        <div class="flex items-center gap-3">
                                            
                                            <div class="min-w-0">
                                                <p class="font-semibold text-gray-900 dark:text-gray-100 truncate">
                                                    {{ $item->product->name }}
                                                </p>
                                                @if(!empty($item->product->sku))
                                                    <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                                                        SKU: {{ $item->product->sku }}
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Price -->
                                    <td data-price="{{ $item->price }}" class="px-5 py-4 font-semibold 
                                            text-gray-900 dark:text-gray-100 whitespace-nowrap">
                                        ৳{{ number_format($item->price, 0) }}/-
                                    </td>

                                    <!-- Qty -->
                                    <td class="px-5 py-4">
                                        <div class="inline-flex items-center rounded-xl
                                                    border border-gray-200 dark:border-gray-600
                                                    bg-white dark:bg-gray-900
                                                    shadow-sm dark:shadow-[inset_0_0_0_1px_rgba(255,255,255,0.04)]">

                                            <!-- minus -->
                                            <button type="button"
                                                class="btn-minus w-10 h-10 flex items-center justify-center
                                                    bg-gray-50 hover:bg-gray-100
                                                    dark:bg-gray-800 dark:hover:bg-gray-700
                                                    text-gray-800 dark:text-gray-100 font-bold transition"
                                                data-id="{{ $item->id }}">
                                                −
                                            </button>

                                            <!-- input -->
                                            <input
                                                type="text" class="qty-input w-16 h-10 text-center font-extrabold tabular-nums
                                                    bg-white dark:bg-gray-900
                                                    text-gray-900 dark:text-white
                                                    border-x border-gray-200 dark:border-gray-700
                                                    outline-none"
                                                data-id="{{ $item->id }}" value="{{ $item->quantity }}"/>

                                            <!-- plus -->
                                            <button type="button"
                                                class="btn-plus w-10 h-10 flex items-center justify-center
                                                    bg-gray-50 hover:bg-gray-100
                                                    dark:bg-gray-800 dark:hover:bg-gray-700
                                                    text-gray-800 dark:text-gray-100 font-bold transition"
                                                data-id="{{ $item->id }}">
                                                +
                                            </button>
                                        </div>


                                        <p id="qty-msg-{{ $item->id }}"
                                        class="mt-1 text-[11px] leading-4
                                                text-gray-500 dark:text-gray-400"></p>
                                    </td>

                                    <!-- Subtotal -->
                                    <td class="item-subtotal px-5 py-4 font-extrabold text-gray-900 dark:text-white whitespace-nowrap">
                                        ৳{{ number_format($item->price * $item->quantity, 0) }}/-
                                    </td>

                                    <!-- Remove -->
                                    <td class="px-5 py-4">
                                        <a href="{{ route('cart.remove', [$item->product_id, $item->reg]) }}"
                                        onclick="return confirm('Remove this item from cart?')"
                                        class="inline-flex items-center justify-center
                                                w-10 h-10 rounded-xl text-red-600 hover:bg-red-50
                                                dark:border-red-900/60 dark:text-red-300 dark:hover:bg-red-900/30
                                                transition focus:outline-none focus:ring-2 focus:ring-red-400/40">
                                            <i class="fas fa-trash text-sm"></i>
                                        </a>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>



    </div>
</div>
















<!-- RIGHT : col-4 -->
<div class="col-span-12 md:col-span-4">
    <div class="p-5 bg-white rounded-lg shadow-xs dark:bg-gray-800">

        <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">
            Cart Summary
        </h4>

        <form action="{{ route('order.confirm') }}" method="POST" id="myForm"
            class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl shadow-sm overflow-hidden">
            @csrf

            <div class="p-5 sm:p-6 space-y-6">

                <!-- Hidden -->
                <input type="hidden" id="cart-total-input" name="txtSubTotal"
                    value="{{ $cart->sum(fn($i) => $i->price * $i->quantity) }}">
                <input type="text" hidden value="{{ $reg }}" name="txtReg">

                <!-- Header -->
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100">ORD-{{ $reg }}</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Checkout & Payment Summary</p>
                    </div>
                </div>

                <!-- Location -->
                <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 p-4">
                    <h4 class="text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2 flex items-center gap-2">
                        <i class="mdi mdi-map-marker text-gray-500 dark:text-gray-400"></i>
                        Location
                    </h4>
                    <p class="text-sm text-gray-600 dark:text-gray-300">{{$company->address}}</p>
                </div>

                <!-- Summary -->
                <div class="rounded-xl border border-gray-200 dark:border-gray-700 p-4">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <p class="text-sm text-gray-600 dark:text-gray-300">Total</p>
                            <p class="text-base font-bold text-gray-900 dark:text-gray-100">
                                ৳<span id="cart-total">{{ number_format($cart->sum(fn($i) => $i->price * $i->quantity), 0) }}</span>/-
                            </p>
                        </div>

                        <div class="flex items-center justify-between">
                            <p class="text-sm text-gray-600 dark:text-gray-300">Shipping Fee</p>
                            <p class="text-sm font-semibold text-gray-800 dark:text-gray-200">
                                ৳<span id="shipping-fee">0.00</span>/-
                            </p>
                        </div>

                        <div class="flex items-center justify-between">
                            <p class="text-sm text-gray-600 dark:text-gray-300">VAT %</p>
                            <p class="text-sm font-semibold text-gray-800 dark:text-gray-200">
                                ৳<span id="vat-amount">0.00</span>/-
                            </p>
                        </div>

                        <div class="flex items-center justify-between">
                            <p class="text-sm text-gray-600 dark:text-gray-300">Discount</p>
                            <p class="text-sm font-semibold text-gray-800 dark:text-gray-200">
                                ৳<span id="discount-amount">0.00</span>/-
                            </p>
                        </div>

                        <div class="border-t border-gray-200 dark:border-gray-700 pt-3 flex items-center justify-between">
                            <p class="text-sm text-gray-600 dark:text-gray-300">Subtotal ({{ $count }} items)</p>
                            <p class="text-lg font-extrabold text-gray-900 dark:text-gray-100">
                                ৳<span id="cart-subtotal">{{ number_format($cart->sum(fn($i) => $i->price * $i->quantity), 0) }}</span>/-
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Payment Inputs -->
                <div class="rounded-xl border border-gray-200 dark:border-gray-700 p-4 space-y-4">
                    <h4 class="text-sm font-semibold text-gray-800 dark:text-gray-200">Payment Details</h4>

                    <!-- VAT -->
                    <div class="grid grid-cols-12 gap-3 items-center">
                        <label for="num4" class="col-span-12 sm:col-span-4 text-sm font-medium text-gray-700 dark:text-gray-300">
                            VAT (%)
                        </label>
                        <div class="col-span-12 sm:col-span-8">
                            <input type="number" class="w-full px-4 py-2.5 text-sm rounded-lg border
                                bg-white dark:bg-gray-700
                                border-gray-200 dark:border-gray-600
                                text-gray-800 dark:text-gray-100
                                placeholder-gray-400 dark:placeholder-gray-400
                                focus:outline-none focus:ring-2 focus:ring-purple-200 dark:focus:ring-purple-900 focus:border-purple-500"
                                id="num4" name="txtVAT" value="0" placeholder="VAT" step="0.01" inputmode="decimal"
                                onkeyup="calculateAmount()" onchange="calculateAmount()" min="0">
                        </div>
                    </div>

                    <!-- Discount -->
                    <div class="grid grid-cols-12 gap-3 items-center">
                        <label for="num3" class="col-span-12 sm:col-span-4 text-sm font-medium text-gray-700 dark:text-gray-300">
                            Discount
                        </label>
                        <div class="col-span-12 sm:col-span-8">
                            <input type="number" class="w-full px-4 py-2.5 text-sm rounded-lg border
                                bg-white dark:bg-gray-700
                                border-gray-200 dark:border-gray-600
                                text-gray-800 dark:text-gray-100
                                placeholder-gray-400 dark:placeholder-gray-400
                                focus:outline-none focus:ring-2 focus:ring-purple-200 dark:focus:ring-purple-900 focus:border-purple-500"
                                id="num3" name="txtDiscount" value="0" placeholder="Discount" step="0.01" inputmode="decimal"
                                onkeyup="calculateAmount()" onchange="calculateAmount()" min="0">
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="grid grid-cols-12 gap-3 items-center">
                        <label for="paymentMethods" class="col-span-12 sm:col-span-4 text-sm font-medium text-gray-700 dark:text-gray-300">
                            P.M
                        </label>
                        <div class="col-span-12 sm:col-span-8">
                            <select name="paymentMethods" id="paymentMethods"
                                class="w-full px-4 py-2.5 text-sm rounded-lg border
                                    bg-white dark:bg-gray-700
                                    border-gray-200 dark:border-gray-600
                                    text-gray-800 dark:text-gray-100
                                    focus:outline-none focus:ring-2 focus:ring-purple-200 dark:focus:ring-purple-900 focus:border-purple-500">
                                @foreach($payMathod as $val)
                                    <option value="{{$val->id}}">{{ $val->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Pay -->
                    <div class="grid grid-cols-12 gap-3 items-center">
                        <label for="num2" class="col-span-12 sm:col-span-4 text-sm font-medium text-gray-700 dark:text-gray-300">
                            Pay
                        </label>
                        <div class="col-span-12 sm:col-span-8">
                            <input type="number" class="w-full px-4 py-2.5 text-sm rounded-lg border
                                bg-white dark:bg-gray-700
                                border-gray-200 dark:border-gray-600
                                text-gray-800 dark:text-gray-100
                                placeholder-gray-400 dark:placeholder-gray-400
                                focus:outline-none focus:ring-2 focus:ring-purple-200 dark:focus:ring-purple-900 focus:border-purple-500"
                                id="num2" name="txtPay" placeholder="Pay" step="0.01" inputmode="decimal"
                                onkeyup="calculateAmount()" onchange="calculateAmount()" min="0">
                        </div>
                    </div>

                    <!-- Customer info (hidden by default) -->
                    <div id="customer-info" class="pt-2">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="customerName" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                    C. Name
                                </label>
                                <input type="text" name="txtCustomerName" id="customerName" placeholder="Customer Name"
                                    class="mt-1 w-full px-4 py-2.5 text-sm rounded-lg border
                                            bg-white dark:bg-gray-700
                                            border-gray-200 dark:border-gray-600
                                            text-gray-800 dark:text-gray-100
                                            placeholder-gray-400 dark:placeholder-gray-400
                                            focus:outline-none focus:ring-2 focus:ring-purple-200 dark:focus:ring-purple-900 focus:border-purple-500">
                            </div>

                            <div>
                                <label for="customerPhone" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                    C. Phone
                                </label>
                                <input type="text" name="txtCustomerPhone" id="customerPhone" placeholder="Customer Phone"
                                    class="mt-1 w-full px-4 py-2.5 text-sm rounded-lg border
                                            bg-white dark:bg-gray-700
                                            border-gray-200 dark:border-gray-600
                                            text-gray-800 dark:text-gray-100
                                            placeholder-gray-400 dark:placeholder-gray-400
                                            focus:outline-none focus:ring-2 focus:ring-purple-200 dark:focus:ring-purple-900 focus:border-purple-500">
                            </div>
                        </div>
                    </div>

                    <!-- Result -->
                    <div class="pt-2">
                        <p id="result" class="text-base sm:text-lg font-extrabold text-red-600 dark:text-red-400">
                            Amount: 00/-
                        </p>
                    </div>
                </div>

                <!-- Submit -->
                <button type="submit" id="confirmBtn"
                    class="w-full inline-flex items-center justify-center px-4 py-2 text-sm font-medium
                        text-white bg-blue-600 rounded-lg
                        hover:bg-blue-700 transition
                        focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2
                        dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-offset-gray-800">
                    <span id="btnText">Confirm</span>
                </button>

            </div>
        </form>

    </div>
</div>