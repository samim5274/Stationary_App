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
                           {{ $transection->bank->bank_name }}
                        </h2>

                        {{-- RIGHT : Action Button --}}
                        <div>
                            <a href="{{ route('bank.transection') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium
                                    text-white bg-blue-600 rounded-lg
                                    hover:bg-blue-700 transition
                                    focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2
                                    dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-offset-gray-800">
                                <i class="fa-solid fa-arrow-left mr-2"></i>
                                Back
                            </a>
                        </div>
                    </div>


                    @include('layouts.message')

                    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

                        {{-- Header --}}
                        @php
                            $status = strtolower($transection->status ?? '');
                            $isDeposit = $status === 'deposit';
                        @endphp

                        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between mb-6">
                            <div class="flex items-start gap-3">
                                <div class="h-11 w-11 rounded-xl flex items-center justify-center
                                    {{ $isDeposit ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-gray-300'
                                                : 'bg-rose-100 text-rose-700 dark:bg-rose-900/40 dark:text-gray-300' }}">
                                    <i class="fa-solid {{ $isDeposit ? 'fa-circle-arrow-down' : 'fa-circle-arrow-up' }}"></i>
                                </div>

                                <div>
                                    <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100 leading-tight">
                                        Bank Transaction Details
                                    </h1>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                        Reference: <span class="font-semibold text-gray-700 dark:text-gray-200">#{{ $transection->id }}</span>
                                        <span class="mx-2 text-gray-300 dark:text-gray-600">•</span>
                                        {{ !empty($transection->date) ? \Carbon\Carbon::parse($transection->date)->format('d M Y') : 'N/A' }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex flex-wrap items-center gap-2">
                                <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-sm font-semibold
                                    {{ $isDeposit ? 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200 dark:bg-emerald-900/30 dark:text-gray-300 dark:ring-gray-800'
                                                : 'bg-rose-50 text-rose-700 ring-1 ring-rose-200 dark:bg-rose-900/30 dark:text-gray-300 dark:ring-gray-800' }}">
                                    <span class="h-2 w-2 rounded-full {{ $isDeposit ? 'bg-emerald-600' : 'bg-rose-600' }}"></span>
                                    {{ ucfirst($status ?: 'N/A') }}
                                </span>

                                {{-- Print (optional route) --}}
                                <a href="{{ route('print.transection', $transection->id) }}" target="_blank"
                                class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold
                                        text-white bg-blue-600 hover:bg-blue-700 transition">
                                    <i class="fa-solid fa-print"></i>
                                    Print
                                </a>
                            </div>
                        </div>

                        {{-- Main Grid --}}
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 lg:gap-6">

                            {{-- Left: Summary card --}}
                            <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
                                <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700 bg-gray-50/60 dark:bg-gray-900">
                                    <h2 class="text-sm font-semibold text-gray-700 dark:text-gray-200">Transaction Summary</h2>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Bank, amount, date and remarks</p>
                                </div>

                                <div class="p-6">
                                    <dl class="space-y-4 text-sm">

                                        <div class="flex items-start justify-between gap-6">
                                            <dt class="text-gray-500 dark:text-gray-400 font-medium w-32 shrink-0">Bank</dt>
                                            <dd class="text-gray-800 dark:text-gray-100 text-right">
                                                <div class="font-semibold">
                                                    {{ $transection->bank->bank_name ?? 'N/A' }}
                                                </div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                    {{ $transection->bank->branch_name ?? '' }}
                                                    @if(!empty($transection->bank?->account_number))
                                                        <span class="text-gray-300 dark:text-gray-600 mx-1">•</span>
                                                        A/C: {{ $transection->bank->account_number }}
                                                    @endif
                                                </div>
                                            </dd>
                                        </div>

                                        <div class="flex items-start justify-between gap-6">
                                            <dt class="text-gray-500 dark:text-gray-400 font-medium w-32 shrink-0">Amount</dt>
                                            <dd class="text-right">
                                                <span class="text-2xl font-bold
                                                    {{ $isDeposit ? 'text-emerald-700 dark:text-gray-300' : 'text-rose-700 dark:text-gray-300' }}">
                                                    {{ $isDeposit ? '+' : '-' }} ৳ {{ number_format($transection->amount ?? 0, 2) }}/-
                                                </span>
                                            </dd>
                                        </div>

                                        <div class="flex items-start justify-between gap-6">
                                            <dt class="text-gray-500 dark:text-gray-400 font-medium w-32 shrink-0">Date</dt>
                                            <dd class="text-gray-800 dark:text-gray-100 text-right">
                                                {{ !empty($transection->date) ? \Carbon\Carbon::parse($transection->date)->format('d M, Y') : 'N/A' }}
                                            </dd>
                                        </div>

                                        <div class="flex items-start justify-between gap-6">
                                            <dt class="text-gray-500 dark:text-gray-400 font-medium w-32 shrink-0">Handled By</dt>
                                            <dd class="text-gray-800 dark:text-gray-100 text-right">
                                                {{ $transection->user->first_name ?? 'N/A' }}
                                                {{ $transection->user->last_name ?? 'N/A' }}
                                            </dd>
                                        </div>

                                        <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                                            <dt class="text-gray-500 dark:text-gray-400 font-medium mb-2">Remarks</dt>
                                            <dd class="text-gray-800 dark:text-gray-100 leading-relaxed">
                                                {{ $transection->remarks ?: '—' }}
                                            </dd>
                                        </div>

                                    </dl>
                                </div>
                            </div>

                            {{-- Right: Quick info cards --}}
                            <div class="space-y-4">

                                <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm p-5">
                                    <p class="text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">Transaction Type</p>
                                    <p class="mt-2 text-lg font-bold text-gray-800 dark:text-gray-100">
                                        {{ $isDeposit ? 'Deposit' : 'Withdrawal' }}
                                    </p>
                                </div>

                                <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm p-5">
                                    <p class="text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">Bank ID</p>
                                    <p class="mt-2 text-lg font-bold text-gray-800 dark:text-gray-100">
                                        {{ $transection->bank_id ?? 'N/A' }}
                                    </p>
                                </div>

                                <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm p-5">
                                    <p class="text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">Created At</p>
                                    <p class="mt-2 text-sm font-semibold text-gray-800 dark:text-gray-100">
                                        {{ optional($transection->created_at)->format('d M, Y h:i A') ?? 'N/A' }}
                                    </p>
                                </div>

                                {{-- Delete (optional) --}}
                                {{-- <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm p-5">
                                    <form action="{{ route('bank.transections.delete', $transection->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this transaction?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg
                                                    text-white bg-rose-600 hover:bg-rose-700 transition font-semibold">
                                            <i class="fa-solid fa-trash"></i>
                                            Delete Transaction
                                        </button>
                                    </form>
                                </div> --}}

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




</body>
</html>
