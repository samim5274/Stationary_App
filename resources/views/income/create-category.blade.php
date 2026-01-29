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
                           Income Category Setting
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
                            <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900">
                                <div class="flex items-start justify-between gap-4">
                                    <div class="flex items-start gap-3 py-4">
                                        <div class="h-10 w-10 rounded-xl bg-blue-600/10 dark:bg-blue-500/10 flex items-center justify-center">
                                            <i class="fa-solid {{ isset($incomeCategory) ? 'fa-pen-to-square' : 'fa-layer-group' }} text-blue-600 dark:text-blue-400"></i>
                                        </div>

                                        <div>
                                            <h2 class="text-lg font-bold text-gray-800 dark:text-gray-100">
                                                {{ isset($incomeCategory) ? 'Edit Income Category' : 'Create Income Category' }}
                                            </h2>
                                            <p class="text-sm text-gray-500 dark:text-gray-300 mt-1">
                                                Add/update categories for income tracking.
                                            </p>
                                        </div>
                                    </div>

                                    {{-- Status Badge --}}
                                    <span class="inline-flex items-center px-3 py-4 rounded-full text-xs font-semibold dark:text-gray-100
                                        {{ isset($incomeCategory)
                                            ? 'bg-amber-100 text-amber-700 dark:bg-amber-500/10 dark:text-amber-300'
                                            : 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300' }}">
                                        {{ isset($incomeCategory) ? 'Editing' : 'New' }}
                                    </span>
                                </div>
                            </div>

                            {{-- Form --}}
                            <form action="{{ isset($incomeCategory)
                                    ? route('income.categories.update', $incomeCategory->id)
                                    : route('income-excategories.store') }}" method="POST" class="p-6 space-y-6">

                                @csrf
                                @if(isset($incomeCategory))
                                    @method('PUT')
                                @endif

                                {{-- Field --}}
                                <div class="space-y-2">
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200">
                                        Category Name <span class="text-red-500">*</span>
                                    </label>

                                    <div class="relative">
                                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                            <i class="fa-solid fa-tag"></i>
                                        </span>

                                        <input
                                            type="text"
                                            name="name"
                                            value="{{ old('name', $incomeCategory->name ?? '') }}"
                                            placeholder="e.g. Printing & Photocopy"
                                            class="block w-full rounded-xl border pl-10 pr-4 py-3 text-sm
                                                bg-white dark:bg-gray-700
                                                text-gray-800 dark:text-gray-100
                                                border-gray-300 dark:border-gray-600
                                                placeholder:text-gray-400 dark:placeholder:text-gray-400
                                                focus:border-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-100 dark:focus:ring-blue-900/40
                                                @error('name') border-red-500 focus:border-red-500 focus:ring-red-100 dark:focus:ring-red-900/40 @enderror"
                                            required
                                            autocomplete="off"
                                        >
                                    </div>

                                    <p class="text-xs text-gray-500 dark:text-gray-300">
                                        Give a short & meaningful name (max 255 chars).
                                    </p>

                                    @error('name')
                                        <p class="text-xs text-red-600 dark:text-red-300">
                                            <i class="fa-solid fa-circle-exclamation mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
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
                                        <i class="fa-solid {{ isset($incomeCategory) ? 'fa-pen-to-square' : 'fa-plus' }} mr-2"></i>
                                        {{ isset($incomeCategory) ? 'Update Category' : 'Create Category' }}
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
                                    Keeping the category name unique keeps the report clean.
                                </li>
                                <li class="flex gap-2">
                                    <i class="fa-solid fa-check mt-1 text-emerald-600 dark:text-emerald-400"></i>
                                    “Transport”, “Office”, “Salary”—this is an advantage if you give broad names.
                                </li>
                                <li class="flex gap-2">
                                    <i class="fa-solid fa-check mt-1 text-emerald-600 dark:text-emerald-400"></i>
                                    You can add a subcategory later (Food → Lunch/Dinner).
                                </li>
                            </ul>

                            <div class="mt-6 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 p-4">
                                <p class="text-xs text-gray-600 dark:text-gray-300">
                                    <span class="font-semibold text-gray-800 dark:text-gray-100">Note:</span>
                                    If you are in edit mode, the old name will auto-fill.
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
