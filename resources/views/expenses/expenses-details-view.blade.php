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
                    
                    @include('layouts.message')

                    <div class="space-y-6 mt-4">

                        {{-- Header --}}
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                            <div>
                                <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">
                                    Expense Details
                                </h1>
                                <p class="text-sm text-gray-500 dark:text-gray-300 mt-1">
                                    View full details of this expense record.
                                </p>
                            </div>

                            <div class="flex items-center gap-2">
                                <a href="{{ route('expenses') }}"
                                class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold
                                        bg-gray-100 hover:bg-gray-200 text-gray-700
                                        dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-gray-100">
                                    <i class="fa-solid fa-arrow-left"></i>
                                    Back
                                </a>

                                <a href="{{ route('expenses.print', $expenses->id) }}" target="_blank"
                                class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold
                                        bg-blue-600 hover:bg-blue-700 text-white">
                                    <i class="fa-solid fa-print"></i>
                                    Print
                                </a>

                                <a href="{{ route('expenses-delete', $expenses->id) }}"
                                onclick="return confirm('Are you sure you want to delete this Expense?')"
                                class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold
                                        bg-red-600 hover:bg-red-700 text-white">
                                    <i class="fa-solid fa-trash"></i>
                                    Delete
                                </a>
                            </div>
                        </div>

                        {{-- Main Card --}}
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow border border-gray-100 dark:border-gray-700 overflow-hidden">

                            {{-- Top Strip --}}
                            <div class="p-5 bg-gray-50 dark:bg-gray-700 border-b border-gray-100 dark:border-gray-700">
                                <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                                    <div class="min-w-0">
                                        <p class="text-xs text-gray-500 dark:text-gray-300">Title</p>
                                        <p class="text-lg font-bold text-gray-900 dark:text-gray-100 truncate">
                                            {{ $expenses->title }}
                                        </p>
                                    </div>

                                    <div class="shrink-0">
                                        <p class="text-xs text-gray-500 dark:text-gray-300 sm:text-right">Amount</p>
                                        <p class="text-2xl font-extrabold text-gray-900 dark:text-white sm:text-right">
                                            ৳ {{ number_format($expenses->amount, 2) }}/-
                                        </p>
                                    </div>
                                </div>
                            </div>

                            {{-- Details Grid --}}
                            <div class="p-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                                    {{-- Category --}}
                                    <div class="p-4 rounded-xl border border-gray-100 dark:border-gray-700 bg-white dark:bg-gray-900">
                                        <div class="flex items-start gap-3">                                            
                                            <span class="w-10 h-10 rounded-full bg-purple-100 dark:bg-purple-900/40 flex items-center justify-center">
                                                <i class="fa-solid fa-layer-group text-purple-700 dark:text-purple-200"></i>
                                            </span>
                                            <div class="min-w-0">
                                                <p class="text-xs text-gray-500 dark:text-gray-300">Category</p>
                                                <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                                    {{ $expenses->category->name ?? 'N/A' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Sub Category --}}
                                    <div class="p-4 rounded-xl border border-gray-100 dark:border-gray-700 bg-white dark:bg-gray-900">
                                        <div class="flex items-start gap-3">
                                            <span class="w-10 h-10 rounded-full bg-purple-100 dark:bg-purple-900/40 flex items-center justify-center">
                                                <i class="fa-solid fa-tags text-purple-700 dark:text-purple-200"></i>
                                            </span>
                                            <div class="min-w-0">
                                                <p class="text-xs text-gray-500 dark:text-gray-300">Sub Category</p>
                                                <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                                    {{ $expenses->subcategory->name ?? 'N/A' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Date --}}
                                    <div class="p-4 rounded-xl border border-gray-100 dark:border-gray-700 bg-white dark:bg-gray-900">
                                        <div class="flex items-start gap-3">                                            
                                            <span class="w-10 h-10 rounded-full bg-purple-100 dark:bg-purple-900/40 flex items-center justify-center">
                                                <i class="fa-solid fa-calendar-days text-purple-700 dark:text-purple-200"></i>
                                            </span>
                                            <div class="min-w-0">
                                                <p class="text-xs text-gray-500 dark:text-gray-300">Date</p>
                                                <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                                    {{ \Carbon\Carbon::parse($expenses->date)->format('d M, Y') }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Created / User (optional) --}}
                                    <div class="p-4 rounded-xl border border-gray-100 dark:border-gray-700 bg-white dark:bg-gray-900">
                                        <div class="flex items-start gap-3">
                                            <span class="w-10 h-10 rounded-full bg-purple-100 dark:bg-purple-900/40 flex items-center justify-center">
                                                <i class="fa-solid fa-user text-purple-700 dark:text-purple-200"></i>
                                            </span>
                                            <div class="min-w-0">
                                                <p class="text-xs text-gray-500 dark:text-gray-300">Added By</p>
                                                <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                                    {{ $expenses->user->first_name ?? 'N/A' }} {{ $expenses->user->last_name ?? 'N/A' }}
                                                </p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                    {{ optional($expenses->created_at)->format('d M, Y h:i A') ?? '' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                {{-- Remark / Description --}}
                                <div class="mt-5 p-5 rounded-xl border border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-900">
                                    <div class="flex items-center gap-2 mb-2">
                                        <i class="fa-solid fa-file-lines text-gray-500 dark:text-gray-300"></i>
                                        <p class="text-sm font-semibold text-gray-800 dark:text-gray-100">Remark</p>
                                    </div>

                                    <p class="text-sm text-gray-700 dark:text-gray-200 leading-relaxed whitespace-pre-line">
                                        {{ $expenses->remark ?? 'N/A' }}
                                    </p>
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


</body>
</html>
