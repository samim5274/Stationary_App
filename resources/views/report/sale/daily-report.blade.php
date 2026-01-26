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
                            Daily Sale Report
                        </h2>

                        {{-- RIGHT : Action Button --}}
                        <a href="#"
                        class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium
                                text-white bg-blue-600 rounded-lg
                                hover:bg-blue-700 transition
                                focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2
                                dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-offset-gray-800">
                            <i class="fa-solid fa-printer mr-2"></i>
                            Print
                        </a>
                    </div>


                    @include('layouts.message')

                    <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
                        <div class="p-5 bg-white dark:bg-gray-800 rounded-xl shadow border dark:border-gray-700">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Today Orders</p>
                            <p class="text-2xl font-bold text-gray-800 dark:text-gray-100">৳ {{ $summary['orders_count'] }}/-</p>
                        </div>

                        <div class="p-5 bg-white dark:bg-gray-800 rounded-xl shadow border dark:border-gray-700">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Total Sales</p>
                            <p class="text-2xl font-bold text-gray-800 dark:text-gray-100">৳ {{ number_format($summary['total_sales'], 2) }}/-</p>
                        </div>

                        <div class="p-5 bg-white dark:bg-gray-800 rounded-xl shadow border dark:border-gray-700">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Total Paid</p>
                            <p class="text-2xl font-bold text-gray-800 dark:text-gray-100">৳ {{ number_format($summary['total_pay'], 2) }}/-</p>
                        </div>

                        <div class="p-5 bg-white dark:bg-gray-800 rounded-xl shadow border dark:border-gray-700">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Total Due</p>
                            <p class="text-2xl font-bold text-gray-800 dark:text-gray-100">৳ {{ number_format($summary['total_due'], 2) }}/-</p>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow border dark:border-gray-700 overflow-hidden">
                        <div class="p-5 border-b dark:border-gray-700 flex items-center justify-between gap-3 flex-wrap">
                            <div>
                                <h2 class="text-lg font-bold text-gray-800 dark:text-gray-100">Today Payments</h2>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Collection & Due breakdown</p>
                            </div>

                            <div class="text-sm text-gray-500 dark:text-gray-400 flex gap-4 flex-wrap">
                                <span>Total: <b class="text-gray-800 dark:text-gray-100">{{ number_format($orders->sum('total'), 2) }}</b></span>
                                <span>Pay: <b class="text-gray-800 dark:text-gray-100">{{ number_format($paymentDetails->sum('pay'), 2) }}</b></span>
                                <span>Due: <b class="text-gray-800 dark:text-gray-100">{{ number_format($paymentDetails->sum('due'), 2) }}</b></span>
                            </div>
                        </div>

                        <div class="overflow-x-auto rounded-xl border border-gray-200 dark:border-gray-700">
                            <table class="min-w-full text-sm">
                                <thead class="bg-gray-100 dark:bg-gray-800">
                                    <tr class="text-left text-gray-700 dark:text-gray-200">
                                        <th class="px-5 py-3 font-semibold whitespace-nowrap">#</th>
                                        <th class="px-5 py-3 font-semibold whitespace-nowrap">Date</th>
                                        <th class="px-5 py-3 font-semibold whitespace-nowrap">Order Reg</th>
                                        <th class="px-5 py-3 font-semibold whitespace-nowrap">Method</th>
                                        <th class="px-5 py-3 font-semibold whitespace-nowrap">Customer</th>
                                        <th class="px-5 py-3 font-semibold whitespace-nowrap text-right">Total</th>
                                        <th class="px-5 py-3 font-semibold whitespace-nowrap text-right">Discount</th>
                                        <th class="px-5 py-3 font-semibold whitespace-nowrap text-right">VAT</th>
                                        <th class="px-5 py-3 font-semibold whitespace-nowrap text-right">Payable</th>
                                        <th class="px-5 py-3 font-semibold whitespace-nowrap text-right">Paid</th>
                                        <th class="px-5 py-3 font-semibold whitespace-nowrap text-right">Due</th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200">
                                    @forelse($paymentDetails as $i => $p)
                                        <tr class="transition-colors duration-150
                                                bg-white dark:bg-gray-900
                                                hover:bg-gray-50 dark:hover:bg-gray-800">

                                            <td class="px-5 py-3 whitespace-nowrap">
                                                {{ $i + 1 }}
                                            </td>

                                            <td class="px-5 py-3 whitespace-nowrap">
                                                {{ optional($p->date)->format('d M Y') }}
                                            </td>

                                            <td class="px-5 py-3 font-semibold whitespace-nowrap text-gray-900 dark:text-gray-100 hover:underline">
                                                <a href="{{ route('order.details.view', $p->reg) }}">
                                                    INV-{{ $p->order->reg ?? $p->reg ?? '-' }}
                                                </a>
                                            </td>

                                            <td class="px-5 py-3 whitespace-nowrap">
                                                {{ $p->paymentMethod->name ?? '-' }}
                                            </td>

                                            <td class="px-5 py-3 whitespace-nowrap">
                                                {{ $p->order->customerName ?? '-' }}
                                            </td>

                                            <td class="px-5 py-3 text-right font-semibold whitespace-nowrap text-gray-900 dark:text-gray-100">
                                                ৳ {{ number_format($p->total, 2) }}/-
                                            </td>

                                            {{-- এখানে তোমার ভুল ছিল text-gray-100 (light mode এ vanish করে) --}}
                                            <td class="px-5 py-3 text-right whitespace-nowrap text-gray-700 dark:text-gray-200">
                                                ৳ {{ number_format($p->discount, 2) }}/-
                                            </td>

                                            <td class="px-5 py-3 text-right whitespace-nowrap text-gray-700 dark:text-gray-200">
                                                ৳ {{ number_format($p->vat, 2) }}/-
                                            </td>

                                            <td class="px-5 py-3 text-right font-semibold whitespace-nowrap text-gray-900 dark:text-gray-100">
                                                ৳ {{ number_format($p->payable, 2) }}/-
                                            </td>

                                            <td class="px-5 py-3 text-right whitespace-nowrap">
                                                <span class="font-semibold text-green-700 dark:text-green-300">
                                                    ৳ {{ number_format($p->pay, 2) }}/-
                                                </span>
                                            </td>

                                            <td class="px-5 py-3 text-right whitespace-nowrap">
                                                <span class="font-semibold {{ $p->due > 0 ? 'text-red-700 dark:text-red-300' : 'text-gray-700 dark:text-gray-200' }}">
                                                    ৳ {{ number_format($p->due, 2) }}/-
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="11" class="px-5 py-10 text-center text-gray-600 dark:text-gray-300">
                                                No payments found for today.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>

                            </table>
                        </div>

                        <!-- pagination -->
                        <div class="px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 border-t dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                                {{-- LEFT --}}
                                <div class="flex-1 min-w-0 flex items-center justify-start">
                                    @php
                                        $from  = $paymentDetails->firstItem() ?? 0;
                                        $to    = $paymentDetails->lastItem() ?? 0;
                                        $total = $paymentDetails->total();
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
                                    {{ $paymentDetails->appends(request()->query())->links() }}
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
