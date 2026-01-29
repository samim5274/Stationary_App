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
                           Income Sub-Category Setting
                        </h2>

                        {{-- RIGHT : Action Button --}}
                        <div>
                            <a href="{{ route('income.setting') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium
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

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 lg:gap-6 mb-8">

                        {{-- Main Form Card --}}
                        <div class="lg:col-span-2 rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-sm overflow-hidden">

                            {{-- Header --}}
                            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700
                                    bg-gradient-to-r from-blue-50 to-white
                                    dark:from-gray-900 dark:to-gray-800">
                                <div class="flex items-center justify-between gap-4">

                                    {{-- Left: Icon + Title --}}
                                    <div class="flex items-center gap-4">

                                        <div
                                            class="h-11 w-11 flex items-center justify-center
                                                rounded-2xl bg-blue-600/10 dark:bg-blue-500/10
                                                shrink-0">
                                            <i class="fa-solid {{ isset($incomesubcategory) ? 'fa-pen-to-square' : 'fa-sitemap' }}
                                                    text-blue-600 dark:text-blue-400 text-lg"></i>
                                        </div>

                                        <div class="leading-tight">
                                            <h2 class="text-lg font-extrabold text-gray-800 dark:text-gray-100">
                                                {{ isset($incomesubcategory) ? 'Edit Expense Subcategory' : 'Create Expense Subcategory' }}
                                            </h2>
                                            <p class="text-sm text-gray-500 dark:text-gray-300 mt-0.5">
                                                Select a category and add/update a subcategory for better expense reports.
                                            </p>
                                        </div>
                                    </div>

                                    {{-- Right: Status Badge --}}
                                    @php($isEdit = isset($incomesubcategory))

                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full dark:text-gray-100
                                            text-xs font-semibold shrink-0
                                            {{ $isEdit
                                                    ? 'bg-amber-100 text-amber-800 dark:bg-amber-900/40 dark:!text-amber-200'
                                                    : 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/40 dark:!text-emerald-200'
                                            }}">
                                        <i class="fa-solid {{ $isEdit ? 'fa-rotate' : 'fa-sparkles' }} text-xs"></i>
                                        {{ $isEdit ? 'Editing' : 'New' }}
                                    </span>

                                </div>
                            </div>

                            {{-- Form --}}
                            <form
                                action="{{ isset($incomesubcategory) 
                                ? route('income-subcategories.modify', $incomesubcategory->id) 
                                : route('income-subcategories.store') }}"
                                method="POST"
                                class="p-6 space-y-6" >
                                
                                @csrf
                                @if(isset($incomesubcategory))
                                    @method('PUT')
                                @endif

                                {{-- Category Select --}}
                                <div class="space-y-2">
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200">
                                        Select Category <span class="text-red-500">*</span>
                                    </label>

                                    <div class="relative">
                                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                            <i class="fa-solid fa-layer-group"></i>
                                        </span>

                                        <select
                                            name="category_id"
                                            class="block w-full rounded-xl border pl-10 pr-10 py-3 text-sm
                                                bg-white dark:bg-gray-700
                                                text-gray-800 dark:text-gray-100
                                                border-gray-300 dark:border-gray-600
                                                focus:border-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-100 dark:focus:ring-blue-900/40
                                                @error('category_id') border-red-500 focus:border-red-500 focus:ring-red-100 dark:focus:ring-red-900/40 @enderror"
                                            required >
                                            <option value="" disabled {{ old('category_id', $incomesubcategory->category_id ?? '') ? '' : 'selected' }}>
                                                -- Select Category --
                                            </option>

                                            @foreach($categories as $cat)
                                                <option value="{{ $cat->id }}"
                                                    @selected(old('category_id', $incomesubcategory->category_id ?? '') == $cat->id)>
                                                    {{ $cat->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <p class="text-xs text-gray-500 dark:text-gray-300">
                                        Select the category under which the subcategory will be placed.
                                    </p>
                                </div>

                                {{-- Subcategory Name --}}
                                <div class="space-y-2">
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200">
                                        Subcategory Name <span class="text-red-500">*</span>
                                    </label>

                                    <div class="relative">
                                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                            <i class="fa-solid fa-tag"></i>
                                        </span>

                                        <input
                                            type="text"
                                            name="name"
                                            value="{{ old('name', $incomesubcategory->name ?? '') }}"
                                            placeholder="e.g. Lunch, Transport Fare"
                                            class="block w-full rounded-xl border pl-10 pr-4 py-3 text-sm
                                                bg-white dark:bg-gray-700
                                                text-gray-800 dark:text-gray-100
                                                border-gray-300 dark:border-gray-600
                                                placeholder:text-gray-400 dark:placeholder:text-gray-400
                                                focus:border-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-100 dark:focus:ring-blue-900/40
                                                @error('name') border-red-500 focus:border-red-500 focus:ring-red-100 dark:focus:ring-red-900/40 @enderror"
                                            required
                                            autocomplete="off">
                                    </div>

                                    <p class="text-xs text-gray-500 dark:text-gray-300">
                                        Example: Food → Lunch/Dinner, Transport → Bus/Rickshaw
                                    </p>
                                </div>

                                {{-- Footer --}}
                                <div class="pt-2 flex flex-wrap items-center justify-end gap-2">
                                    <a href="{{ route('income.setting') }}"
                                    class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl text-sm font-semibold
                                            border border-gray-300 dark:border-gray-600
                                            text-gray-700 dark:text-gray-200
                                            hover:bg-gray-50 dark:hover:bg-gray-700/60 transition">
                                        <i class="fa-solid fa-arrow-left mr-2"></i>
                                        Back
                                    </a>

                                    <button type="submit"
                                            class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl text-sm font-semibold
                                                text-white bg-blue-600 hover:bg-blue-700 transition
                                                focus:outline-none focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-900/40">
                                        <i class="fa-solid {{ isset($incomesubcategory) ? 'fa-pen-to-square' : 'fa-plus' }} mr-2"></i>
                                        {{ isset($incomesubcategory) ? 'Update Subcategory' : 'Create Subcategory' }}
                                    </button>
                                </div>

                            </form>
                        </div>

                        {{-- Side Info Panel --}}
                        <div class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-sm p-6">
                            <h3 class="text-sm font-bold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                                <i class="fa-solid fa-circle-info text-blue-600 dark:text-blue-400"></i>
                                Tips
                            </h3>

                            <ul class="mt-4 space-y-3 text-sm text-gray-600 dark:text-gray-300">
                                <li class="flex gap-2">
                                    <i class="fa-solid fa-check mt-1 text-emerald-600 dark:text-emerald-400"></i>
                                    Keeping the subcategory name according to the category makes search/report easier.
                                </li>
                                <li class="flex gap-2">
                                    <i class="fa-solid fa-check mt-1 text-emerald-600 dark:text-emerald-400"></i>
                                    Keep category-wise unique to avoid duplicates (Food → Lunch once).
                                </li>
                                <li class="flex gap-2">
                                    <i class="fa-solid fa-check mt-1 text-emerald-600 dark:text-emerald-400"></i>
                                    Selecting a subcategory in an expense entry clears the analytics.
                                </li>
                            </ul>

                            <div class="mt-6 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 p-4">
                                <p class="text-xs text-gray-600 dark:text-gray-300">
                                    <span class="font-semibold text-gray-800 dark:text-gray-100">Note:</span>
                                    Changing the category will change the grouping/report.
                                </p>
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
