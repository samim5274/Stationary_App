<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>{{ $company->name ?? config('app.name', 'N/A') }}</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"/>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('assets/css/tailwind.output.css') }}" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css"/>

  @vite(['resources/js/app.js'])
</head>
<body>

    <div class="flex h-screen bg-gray-50 dark:bg-gray-900" :class="{ 'overflow-hidden': isSideMenuOpen }">
        @include('layouts.navbar')
        <div class="flex flex-col flex-1 w-full">
            @include('layouts.header')
            <main class="h-full overflow-y-auto">
                <div class="container px-6 mx-auto grid">
                    
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between my-4">
                        {{-- LEFT : Title --}}
                        <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">
                            Product Details
                        </h2>

                        {{-- RIGHT : Action Button --}}
                        <a href="{{ route('product.create.view') }}"
                        class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium
                                text-white bg-blue-600 rounded-lg
                                hover:bg-blue-700 transition
                                focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2
                                dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-offset-gray-800">
                            <i class="fa-solid fa-plus mr-2"></i>
                            Add New Product
                        </a>
                    </div>


                    @include('layouts.message')

                    {{-- Cards --}}
                    <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">

                        <!-- Total -->
                        <div class="flex items-center p-4 bg-white border border-gray-100 rounded-xl shadow-sm
                                    dark:bg-gray-800 dark:border-gray-700">
                            <div class="p-3 mr-4 rounded-full bg-orange-100 dark:bg-orange-500/20">
                            <i class="fa-solid fa-boxes-stacked text-lg text-orange-600 dark:text-orange-300"></i>
                            </div>
                            <div>
                            <p class="mb-1 text-sm font-medium text-gray-500 dark:text-gray-400">Total Products</p>
                            <p class="text-xl font-bold text-gray-800 dark:text-gray-100">{{ number_format($products->total()) }}</p>
                            </div>
                        </div>

                        <!-- Active -->
                        <div class="flex items-center p-4 bg-white border border-gray-100 rounded-xl shadow-sm
                                    dark:bg-gray-800 dark:border-gray-700">
                            <div class="p-3 mr-4 rounded-full bg-green-100 dark:bg-green-500/20">
                            <i class="fa-solid fa-circle-check text-lg text-green-600 dark:text-green-300"></i>
                            </div>
                            <div>
                            <p class="mb-1 text-sm font-medium text-gray-500 dark:text-gray-400">Active Products</p>
                            <p class="text-xl font-bold text-gray-800 dark:text-gray-100">
                                {{ number_format(\App\Models\Product::where('status', 1)->count()) }}
                            </p>
                            </div>
                        </div>

                        <!-- De-active -->
                        <div class="flex items-center p-4 bg-white border border-gray-100 rounded-xl shadow-sm
                                    dark:bg-gray-800 dark:border-gray-700">
                            <div class="p-3 mr-4 rounded-full bg-blue-100 dark:bg-blue-500/20">
                            <i class="fa-solid fa-circle-xmark text-lg text-blue-600 dark:text-blue-300"></i>
                            </div>
                            <div>
                            <p class="mb-1 text-sm font-medium text-gray-500 dark:text-gray-400">De-Active Products</p>
                            <p class="text-xl font-bold text-gray-800 dark:text-gray-100">
                                {{ number_format(\App\Models\Product::where('status', 0)->count()) }}
                            </p>
                            </div>
                        </div>

                        <!-- New -->
                        <div class="flex items-center p-4 bg-white border border-gray-100 rounded-xl shadow-sm
                                    dark:bg-gray-800 dark:border-gray-700">
                            <div class="p-3 mr-4 rounded-full bg-teal-100 dark:bg-teal-500/20">
                                <i class="fa-solid fa-clock text-lg text-teal-600 dark:text-teal-300"></i>
                            </div>
                            <div>
                                <p class="mb-1 text-sm font-medium text-gray-500 dark:text-gray-400">New Products</p>
                                <p class="text-xl font-bold text-gray-800 dark:text-gray-100">
                                    {{ number_format(\App\Models\Product::whereDate('created_at', '>=', now()->subDays(7))->count()) }}
                                </p>
                            </div>
                        </div>

                    </div>


                    {{-- Table --}}
                    <div class="w-full overflow-hidden rounded-lg shadow-xs">
                        {{-- Search Bar --}}
                        <form method="GET" action="{{ route('product.list') }}" class="mb-4">
                            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                <div class="relative w-full sm:max-w-md">
                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </span>

                                    <input
                                        name="q"
                                        value="{{ request('q') }}"
                                        placeholder="Search product / sku / category..."
                                        class="w-full rounded-lg border border-gray-200 bg-white px-10 py-2 text-sm
                                            text-gray-700 focus:border-purple-400 focus:outline-none focus:ring-2 focus:ring-purple-200
                                            dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 dark:focus:ring-purple-900"
                                    />

                                    @if(request('q'))
                                        <a href="{{ route('product.list') }}"
                                        class="absolute right-2 top-1/2 -translate-y-1/2 rounded-md px-2 py-1 text-xs
                                                text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700">
                                            Clear
                                        </a>
                                    @endif
                                </div>

                                <button class="px-4 py-2 rounded-lg bg-purple-600 text-white text-sm font-semibold hover:bg-purple-700">
                                    Search
                                </button>
                            </div>
                        </form>

                        <div class="w-full overflow-x-auto">
                            <table class="w-full whitespace-nowrap">
                                <thead>
                                    <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b
                                            dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                        <th class="px-4 py-3">Product</th>
                                        <th class="px-4 py-3">Category</th>
                                        <th class="px-4 py-3">Price</th>
                                        <th class="px-4 py-3">Stock</th>
                                        <th class="px-4 py-3">Status</th>
                                        <th class="px-4 py-3 text-right">Action</th>
                                    </tr>
                                </thead>

                                <tbody id="productTbody" class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                                    @forelse($products as $p)
                                        @php
                                            $stock = (int) ($p->stock ?? 0);

                                            $stockClass = $stock <= 0
                                                ? 'text-red-700 bg-red-100 dark:text-red-100 dark:bg-red-700'
                                                : ($stock <= 5
                                                    ? 'text-orange-700 bg-orange-100 dark:text-white dark:bg-orange-600'
                                                    : 'text-green-700 bg-green-100 dark:text-green-100 dark:bg-green-700');
                                        @endphp

                                        <tr class="group text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/40 transition">

                                            {{-- Product --}}
                                            <td class="px-4 py-3">
                                                <div class="flex items-center text-sm">

                                                    {{-- IMAGE OR LETTER AVATAR --}}
                                                    <div class="relative hidden w-10 h-10 mr-3 md:flex items-center justify-center">
                                                        @if(!empty($p->image))
                                                            <div class="w-10 h-10 overflow-hidden rounded-lg bg-gray-100 dark:bg-gray-700">
                                                                <img
                                                                    src="{{ asset('storage/products/'.$p->image) }}"
                                                                    alt="{{ $p->name }}"
                                                                    class="object-cover w-full h-full"
                                                                    loading="lazy"
                                                                />
                                                            </div>
                                                        @else
                                                            <div
                                                                class="w-10 h-10 rounded-full flex items-center justify-center
                                                                    bg-purple-100 text-purple-700 font-extrabold uppercase
                                                                    dark:bg-purple-700 dark:text-purple-100">
                                                                {{ strtoupper(substr($p->name ?? 'P', 0, 1)) }}
                                                            </div>
                                                        @endif
                                                    </div>

                                                    <div>
                                                        <p class="text-xs text-gray-600 dark:text-gray-400 group-hover:text-gray-700 dark:group-hover:text-gray-200">{{ $p->name }}</p>
                                                        <p class="text-xs text-gray-600 dark:text-gray-400">
                                                            SKU: <span class="font-semibold">{{ $p->sku }}</span>
                                                            Slug: <span class="font-semibold">{{ $p->slug }}</span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>

                                            {{-- Category --}}
                                            <td class="px-4 py-3 text-sm">
                                                <div class="font-semibold">{{ $p->category?->name ?? '-' }}</div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                                    {{ $p->subcategory?->name ?? '—' }}
                                                </div>
                                            </td>

                                            {{-- Price --}}
                                            <td class="px-4 py-3 text-sm">
                                                <div class="font-semibold">৳ {{ number_format($p->price ?? 0, 2) }}</div>
                                                @if(!empty($p->discount) && $p->discount > 0)
                                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                                        Discount: ৳ {{ number_format($p->discount, 2) }}
                                                    </div>
                                                @endif
                                            </td>

                                            {{-- Stock --}}
                                            <td class="px-4 py-3 text-xs">
                                                <span class="px-2 py-1 font-semibold leading-tight rounded-full {{ $stockClass }}">
                                                    {{ $stock }} {{ $p->unit ?? 'pcs' }}
                                                </span>
                                                @if(!empty($p->min_stock) && $stock <= $p->min_stock)
                                                    <div class="text-xs text-red-500 mt-1">Low stock</div>
                                                @endif
                                            </td>

                                            {{-- Status --}}
                                            <td class="px-4 py-3 text-xs">
                                                <span class="px-2 py-1 font-semibold leading-tight rounded-full
                                                    {{ $p->status ? 'text-green-700 bg-green-100 dark:text-green-100 dark:bg-green-700'
                                                                : 'text-gray-700 bg-gray-100 dark:text-gray-100 dark:bg-gray-700' }}">
                                                    {{ $p->status ? 'Active' : 'Inactive' }}
                                                </span>
                                            </td>

                                            {{-- Action --}}
                                            <td class="px-4 py-3">
                                                <div class="flex items-center justify-end space-x-2">
                                                    <a href="{{ route('product.edit', [$p->id, $p->sku, $p->slug]) }}" class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700" title="Edit">
                                                        <i class="fa-regular fa-pen-to-square"></i>
                                                    </a>
                                                    <form action="{{ route('product.delete', $p->id) }}" method="POST" onsubmit="return confirm('Delete this product?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="p-2 rounded-lg text-red-600 hover:bg-red-50 dark:hover:bg-red-900/30"
                                                            title="Delete">
                                                            <i class="fa-regular fa-trash-can"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-4 py-6 text-center text-sm text-gray-500 dark:text-gray-400">
                                                No products found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{-- Pagination --}}
                        <div class="px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 border-t dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                                {{-- LEFT --}}
                                <div class="flex-1 min-w-0 flex items-center justify-start">
                                    @php
                                        $from  = $products->firstItem() ?? 0;
                                        $to    = $products->lastItem() ?? 0;
                                        $total = $products->total();
                                    @endphp
                                    <span class="truncate">
                                        Showing
                                        <span class="mx-1 text-gray-800 dark:text-gray-100">{{ $from }}</span>
                                        -
                                        <span class="mx-1 text-gray-800 dark:text-gray-100">{{ $to }}</span>
                                        of
                                        <span class="mx-1 text-gray-800 dark:text-gray-100">{{ $total }}</span>
                                    </span>
                                </div>

                                {{-- RIGHT (Keep your smart pagination here if needed) --}}
                                <div class="shrink-0 flex items-center justify-end">
                                    {{ $products->appends(request()->query())->links() }}
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </main>

        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <script src="{{ asset('assets/js/init-alpine.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" defer></script>
    <script src="{{ asset('assets/js/charts-lines.js') }}" defer></script>
    <script src="{{ asset('assets/js/charts-pie.js') }}" defer></script>

</body>
</html>
