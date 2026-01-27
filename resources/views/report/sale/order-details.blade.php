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
                    
                    <div class="flex items-start justify-between gap-4 flex-wrap my-4">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                                Order Details
                            </h1>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                Invoice / Reg: <span class="font-semibold text-gray-900 dark:text-gray-100">INV-{{ $order->reg }}</span>
                            </p>
                        </div>

                        <div class="flex items-center gap-2">
                            <a href="{{ url()->previous() }}"
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border
                                    border-gray-200 dark:border-gray-700
                                    bg-white dark:bg-gray-900
                                    text-gray-700 dark:text-gray-200
                                    hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                                <i class="fa-solid fa-arrow-left"></i>
                                Back
                            </a>

                            {{-- If you have print route/button, you can use it. Otherwise keep this as simple JS print --}}
                            <a href="{{ route('order-print', $order->reg) }}" target="_blank"
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-lg
                                    bg-purple-600 text-white hover:bg-purple-700 transition">
                                <i class="fa-solid fa-print"></i>
                                Print
                            </a>
                        </div>
                    </div>


                    @include('layouts.message')

                    
                    <div class="space-y-6">

                        {{-- Top bar --}}
                        

                        {{-- Company + Invoice header --}}
                        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
                            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                                <div class="flex items-start justify-between gap-6 flex-wrap">
                                    <div>
                                        <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">
                                            {{ $company->name ?? 'Company Name' }}
                                        </h2>
                                        <div class="mt-2 text-sm text-gray-600 dark:text-gray-400 space-y-1">
                                            @if(!empty($company->address)) <p>{{ $company->address }}</p> @endif
                                            @if(!empty($company->phone))   <p>Phone: {{ $company->phone }}</p> @endif
                                            @if(!empty($company->email))   <p>Email: {{ $company->email }}</p> @endif
                                        </div>
                                    </div>

                                    <div class="text-sm text-gray-700 dark:text-gray-200 space-y-1">
                                        
                                        <p><span class="text-gray-500 dark:text-gray-400">Cashier:</span>
                                            <b>{{ $order->user?->first_name ?? '-' }} {{ $order->user?->last_name ?? '' }}</b>
                                        </p>

                                        {{-- Order status badge --}}
                                        @php
                                            $statusMap = [
                                                0 => ['Pending',   'bg-gray-200 text-gray-900 dark:bg-gray-700 dark:text-gray-100'],
                                                1 => ['Ordered',   'bg-green-200 text-green-900 dark:bg-green-900/30 dark:text-green-200'],
                                                2 => ['Cancelled', 'bg-red-200 text-red-900 dark:bg-red-900/30 dark:text-red-200'],
                                            ];
                                            [$stLabel, $stCls] = $statusMap[$order->status] ?? ['Unknown','bg-amber-200 text-amber-900 dark:bg-amber-900/30 dark:text-amber-200'];
                                        @endphp

                                        <span class="inline-flex items-center gap-2 mt-2 px-3 py-1 rounded-full text-xs font-semibold {{ $stCls }}">
                                            <span class="w-1.5 h-1.5 rounded-full {{ $order->status == 1 ? 'bg-green-600' : ($order->status == 2 ? 'bg-red-600' : 'bg-gray-500') }}"></span>
                                            {{ $stLabel }}
                                        </span>
                                        
                                    </div>
                                </div>
                                <div class="mt-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 p-4">

                                    <div class="flex items-start justify-between gap-6 flex-wrap">

                                        {{-- Left: Customer --}}
                                        <div class="space-y-1">
                                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                                Customer
                                            </p>

                                            <p class="text-base font-semibold text-gray-900 dark:text-gray-100">
                                                {{ $order->customerName ?? '-' }}
                                            </p>

                                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                                Phone:
                                                <span class="font-semibold text-gray-900 dark:text-gray-100">
                                                    {{ $order->customerPhone ?? '-' }}
                                                </span>
                                            </p>
                                        </div>

                                        {{-- Right: Order meta --}}
                                        <div class="text-sm text-gray-600 dark:text-gray-400 text-right">
                                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                                Order Details
                                            </p>
                                            <p>
                                                <span class="text-gray-500 dark:text-gray-400">Invoice:</span> <b>INV-{{ $order->reg }}</b>
                                            </p>
                                            <p>
                                                <span class="text-gray-500 dark:text-gray-400">Date:</span> <b>{{ optional($order->date)->format('d M Y') }}</b>
                                            </p>                                            
                                        </div>

                                    </div>
                                </div>
                            </div>

                            

                            {{-- Product + Totals --}}
                            <div class="p-6 grid gap-6 lg:grid-cols-3">

                                {{-- Product --}}
                                <div class="lg:col-span-2">                                    
                                    <div class="overflow-x-auto rounded-xl border border-gray-200 dark:border-gray-700">
                                        <table class="min-w-full text-sm">
                                            {{-- Table Head --}}
                                            <thead class="bg-gray-50 dark:bg-gray-800">
                                                <tr class="text-left text-gray-700 dark:text-gray-200">
                                                    <th class="px-4 py-3 font-semibold">Product</th>
                                                    <th class="px-4 py-3 font-semibold text-right">Price × Qty</th>
                                                    <th class="px-4 py-3 font-semibold text-right">Subtotal</th>
                                                </tr>
                                            </thead>

                                            {{-- Table Body --}}
                                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700
                                                        bg-white dark:bg-gray-900
                                                        text-gray-800 dark:text-gray-200">

                                                @foreach($cart as $item)
                                                    <tr class="transition-colors
                                                            hover:bg-gray-50 dark:hover:bg-gray-800">

                                                        {{-- Product --}}
                                                        <td class="px-4 py-3">
                                                            <div class="flex flex-col gap-0.5">
                                                                <span class="font-semibold text-gray-900 dark:text-gray-100">
                                                                    {{ $item->product?->name ?? 'N/A' }}
                                                                </span>
                                                                <span class="text-xs text-gray-500 dark:text-gray-400">
                                                                    Code: {{ $item->product?->code ?? 'N/A' }}
                                                                </span>
                                                            </div>
                                                        </td>

                                                        {{-- Price & Qty --}}
                                                        <td class="px-4 py-3 text-right whitespace-nowrap">
                                                            <div class="text-gray-900 dark:text-gray-100">
                                                                ৳ {{ number_format($item->price, 2) }}
                                                            </div>
                                                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                                                Qty × {{ $item->quantity }}
                                                            </div>
                                                        </td>

                                                        {{-- Subtotal --}}
                                                        <td class="px-4 py-3 text-right whitespace-nowrap">
                                                            <span class="font-semibold text-gray-900 dark:text-gray-100">
                                                                ৳ {{ number_format($item->price * $item->quantity, 2) }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>

                                </div>

                                {{-- Totals --}}
                                <div>
                                    <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-100">Payment Summary</h3>

                                    <div class="mt-3 rounded-xl border border-gray-200 dark:border-gray-700 p-4
                                                bg-white dark:bg-gray-900">
                                        <div class="space-y-2 text-sm">
                                            <div class="flex items-center justify-between text-gray-600 dark:text-gray-400">
                                                <span>Total</span>
                                                <b class="text-gray-900 dark:text-gray-100">৳ {{ number_format($paySummary['total'], 2) }}</b>
                                            </div>

                                            <div class="flex items-center justify-between text-gray-600 dark:text-gray-400">
                                                <span>Discount</span>
                                                <b class="text-gray-900 dark:text-gray-100">৳ {{ number_format($paySummary['discount'], 2) }}</b>
                                            </div>

                                            <div class="flex items-center justify-between text-gray-600 dark:text-gray-400">
                                                <span>VAT</span>
                                                <b class="text-gray-900 dark:text-gray-100">৳ {{ number_format($paySummary['vat'], 2) }}</b>
                                            </div>

                                            <div class="h-px bg-gray-200 dark:bg-gray-700 my-2"></div>

                                            <div class="flex items-center justify-between text-gray-600 dark:text-gray-400">
                                                <span>Payable</span>
                                                <b class="text-gray-900 dark:text-gray-100">৳ {{ number_format($paySummary['payable'], 2) }}</b>
                                            </div>

                                            <div class="flex items-center justify-between text-gray-600 dark:text-gray-400">
                                                <span>Paid</span>
                                                <b class="text-green-700 dark:text-green-300">৳ {{ number_format($paySummary['paid'], 2) }}</b>
                                            </div>

                                            <div class="flex items-center justify-between text-gray-600 dark:text-gray-400">
                                                <span>Due</span>
                                                <b class="{{ $paySummary['due'] > 0 ? 'text-red-700 dark:text-red-300' : 'text-gray-900 dark:text-gray-100' }}">
                                                    ৳ {{ number_format($paySummary['due'], 2) }}
                                                </b>
                                            </div>
                                        </div>
                                    </div>

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
