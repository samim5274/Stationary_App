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
  <meta name="csrf-token" content="{{ csrf_token() }}">
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
                           Bank Transection Details
                        </h2>

                        {{-- RIGHT : Action Button --}}
                        <div>
                            <a href="{{ route('bank.diposit.view') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium
                                    text-white bg-blue-600 rounded-lg
                                    hover:bg-blue-700 transition
                                    focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2
                                    dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-offset-gray-800">
                                <i class="fa-solid fa-piggy-bank mr-2"></i>
                                Diposit
                            </a>
                            <a href="{{ route('bank.withdraw.view') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium
                                    text-white bg-blue-600 rounded-lg
                                    hover:bg-blue-700 transition
                                    focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2
                                    dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-offset-gray-800">
                                    <i class="fa-solid fa-building-columns mr-2"></i>
                                Withdraw
                            </a>
                            <a href="{{ route('bank.to.bank.view') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium
                                    text-white bg-blue-600 rounded-lg
                                    hover:bg-blue-700 transition
                                    focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2
                                    dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-offset-gray-800">
                                    <i class="fa-solid fa-money-bill-transfer mr-2"></i>
                                Bank To Bank
                            </a>
                            <a href="#" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium
                                    text-white bg-blue-600 rounded-lg
                                    hover:bg-blue-700 transition
                                    focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2
                                    dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-offset-gray-800">
                                <i class="fa-solid fa-gear mr-2"></i>
                                Setting
                            </a>
                        </div>
                    </div>


                    @include('layouts.message')

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6 mb-4">
                        {{-- Deposit --}}
                        <div class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-sm hover:shadow-md transition overflow-hidden">
                            <div class="p-5 flex items-start justify-between gap-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Deposit</p>
                                    <h3 class="mt-2 text-2xl sm:text-3xl font-bold text-gray-900 dark:text-gray-100 leading-tight">
                                        ৳ {{ number_format($totalDeposit ?? 0, 2) }}
                                    </h3>
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Today total deposit</p>
                                </div>

                                <div class="h-12 w-12 rounded-2xl bg-emerald-50 dark:bg-emerald-500 flex items-center justify-center dark:text-gray-100">
                                    <i class="fa-solid fa-arrow-turn-down"></i>
                                </div>
                            </div>
                            <div class="h-1 w-full bg-emerald-500/80"></div>
                        </div>

                        {{-- Withdraw --}}
                        <div class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-sm hover:shadow-md transition overflow-hidden">
                            <div class="p-5 flex items-start justify-between gap-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Withdraw</p>
                                    <h3 class="mt-2 text-2xl sm:text-3xl font-bold text-gray-900 dark:text-gray-100 leading-tight">
                                        ৳ {{ number_format($totalWithdraw ?? 0, 2) }}
                                    </h3>
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Today total withdraw</p>
                                </div>

                                <div class="h-12 w-12 rounded-2xl bg-rose-50 dark:bg-rose-500 flex items-center justify-center dark:text-gray-100">
                                    <i class="fa-solid fa-arrow-turn-up"></i>
                                </div>
                            </div>
                            <div class="h-1 w-full bg-rose-500/80"></div>
                        </div>

                        {{-- Balance --}}
                        <div class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-sm hover:shadow-md transition overflow-hidden sm:col-span-2 lg:col-span-1">
                            <div class="p-5 flex items-start justify-between gap-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Balance</p>
                                    <h3 class="mt-2 text-2xl sm:text-3xl font-bold text-gray-900 dark:text-gray-100 leading-tight">
                                        ৳ {{ number_format($balance ?? 0, 2) }}
                                    </h3>
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Deposit - Withdraw</p>
                                </div>

                                <div class="h-12 w-12 rounded-2xl bg-rose-50 text-xl dark:bg-rose-500 flex items-center justify-center dark:text-gray-100">
                                    <i class="fa-solid fa-money-check-dollar"></i>
                                </div>
                            </div>

                            <div class="h-1 w-full bg-indigo-500/80"></div>
                        </div>
                    </div>


                    <div class="grid grid-cols-1 lg:grid-cols-1 gap-4 lg:gap-6 mb-8">                       

                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow overflow-x-auto border border-gray-100 dark:border-gray-700">

                            <table class="min-w-full text-sm">
                                <thead class="bg-gray-100 dark:bg-gray-800 dark:text-gray-100">
                                    <tr>
                                        <th class="px-4 py-3 text-center text-xs font-semibold uppercase">#</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase">Bank Info</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase">User</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase">Amount</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase">Date</th>
                                        <th class="px-4 py-3 text-center text-xs font-semibold uppercase">Status</th>
                                        <th class="px-4 py-3 text-center text-xs font-semibold uppercase">Action</th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-900 dark:text-gray-100">

                                    @forelse($transections as $val)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition">

                                            {{-- SL --}}
                                            <td class="px-4 py-3 text-center">
                                                {{ $loop->iteration }}
                                            </td>

                                            {{-- Bank Info --}}
                                            <td class="px-4 py-3">
                                                <div class="font-semibold text-gray-900 dark:text-gray-100">
                                                    {{ $val->bank->bank_name ?? 'N/A' }}
                                                </div>
                                                <small class="text-gray-500">
                                                    {{ $val->bank->account_number ?? '' }}
                                                </small>
                                            </td>

                                            {{-- User --}}
                                            <td class="px-4 py-3">
                                                {{ $val->user->name ?? 'System' }}
                                            </td>

                                            {{-- Amount --}}
                                            <td class="px-4 py-3 font-semibold">
                                                ৳ {{ number_format($val->amount, 2) }}/-
                                            </td>

                                            {{-- Date --}}
                                            <td class="px-4 py-3">
                                                {{ \Carbon\Carbon::parse($val->date)->format('d M, Y') }}
                                            </td>

                                            {{-- Status --}}
                                            <td class="px-4 py-3 text-center">
                                                @php $status = strtolower($val->status); @endphp
                                                <span
                                                    class="px-2 py-1 rounded-full text-xs font-semibold
                                                    {{ $status === 'withdraw'
                                                        ? 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300'
                                                        : 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300' }}">

                                                    {{ ucfirst($status) }}
                                                </span>
                                            </td>

                                            {{-- Action --}}
                                            <td class="px-4 py-3 text-center">
                                                <div class="flex justify-center gap-3">

                                                    {{-- View --}}
                                                    <a href="{{ route('bank.transection.view', $val->id) }}"
                                                    class="text-blue-600 hover:text-blue-800">
                                                        <i class="fa-solid fa-eye"></i>
                                                    </a>

                                                    {{-- Delete --}}
                                                    <form action="{{ route('delete.transection', $val->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Are you sure you want to delete this transection?')">
                                                        @csrf
                                                        @method('DELETE')

                                                        <button class="text-red-600 hover:text-red-800">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </button>
                                                    </form>

                                                </div>
                                            </td>

                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="px-5 py-10 text-center text-gray-500">
                                                No bank transactions found.
                                            </td>
                                        </tr>
                                    @endforelse

                                </tbody>
                            </table>

                            
                            {{-- Pagination (if used) --}}
                            @if(method_exists($transections, 'links'))
                            <div class="px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 border-t dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                                    {{-- LEFT --}}
                                    <div class="flex-1 min-w-0 flex items-center justify-start">
                                        @php
                                            $from  = $transections->firstItem() ?? 0;
                                            $to    = $transections->lastItem() ?? 0;
                                            $total = $transections->total();
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
                                        {{ $transections->appends(request()->query())->links() }}
                                    </div>

                                </div>
                            </div>
                            @endif
                        </div>

                    </div>

                </div>
            </main>

        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <script src="{{ asset('assets/js/init-alpine.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" defer></script>




</body>
</html>
