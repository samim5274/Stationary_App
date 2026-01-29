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
                           Expenses Setting
                        </h2>

                        {{-- RIGHT : Action Button --}}
                        <div>
                            <a href="{{ route('create-category-view') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium
                                    text-white bg-blue-600 rounded-lg
                                    hover:bg-blue-700 transition
                                    focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2
                                    dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-offset-gray-800">
                                <i class="fa-solid fa-plus mr-2"></i>
                                Add Category
                            </a>
                            <a href="{{ route('create-sub-category-view') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium
                                    text-white bg-blue-600 rounded-lg
                                    hover:bg-blue-700 transition
                                    focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2
                                    dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-offset-gray-800">
                                <i class="fa-solid fa-plus mr-2"></i>
                                Add Sub-Category
                            </a>
                        </div>
                    </div>


                    @include('layouts.message')

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-6 mb-8">


                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow overflow-x-auto border border-gray-100 dark:border-gray-700">

                            <table class="min-w-full text-sm">
                                <thead class="bg-gray-100 dark:bg-gray-800">
                                    <tr>
                                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 dark:text-gray-200 uppercase">#</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-200 uppercase">Name</th>
                                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 dark:text-gray-200 uppercase">Action</th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200">
                                    @forelse($categories as $i => $val)
                                        <tr class="transition-colors duration-150
                                                bg-white dark:bg-gray-900
                                                hover:bg-gray-50 dark:hover:bg-gray-800">

                                            <td class="px-4 py-3 text-center text-sm text-gray-700 dark:text-gray-200">
                                                {{ $loop->iteration }}
                                            </td>

                                            <td class="px-4 py-3 text-sm font-medium text-gray-900 dark:text-gray-100 hover:underline">
                                                {{ $val->name }}
                                            </td>
                                          

                                            {{-- Action --}}
                                            <td class="px-4 py-3 text-center">
                                                <div class="flex items-center justify-center gap-3">

                                                    {{-- View --}}
                                                    <a href="{{ route('excategories.update.view', $val->id) }}"
                                                    class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </a>

                                                    {{-- Delete --}}

                                                    <form action="{{ route('expenses.category.delete', $val->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Are you sure you want to delete this category?')">
                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="submit"
                                                                class="text-red-600 hover:text-red-800 text-sm font-semibold">
                                                            <i class="fa-solid fa-trash mr-1"></i>
                                                        </button>
                                                    </form>

                                                </div>
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
                            {{-- Pagination (if used) --}}
                            @if(method_exists($categories, 'links'))
                            <div class="px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 border-t dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                                    {{-- LEFT --}}
                                    <div class="flex-1 min-w-0 flex items-center justify-start">
                                        @php
                                            $from  = $categories->firstItem() ?? 0;
                                            $to    = $categories->lastItem() ?? 0;
                                            $total = $categories->total();
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
                                        {{ $categories->appends(request()->query())->links() }}
                                    </div>

                                </div>
                            </div>
                            @endif
                        </div>
                        

                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow overflow-x-auto border border-gray-100 dark:border-gray-700">

                            <table class="min-w-full text-sm">
                                <thead class="bg-gray-100 dark:bg-gray-800">
                                    <tr>
                                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 dark:text-gray-200 uppercase">#</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-200 uppercase">Name</th>
                                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 dark:text-gray-200 uppercase">Action</th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200">
                                    @forelse($subcategories as $i => $val)
                                        <tr class="transition-colors duration-150
                                                bg-white dark:bg-gray-900
                                                hover:bg-gray-50 dark:hover:bg-gray-800">

                                            <td class="px-4 py-3 text-center text-sm text-gray-700 dark:text-gray-200">
                                                {{ $loop->iteration }}
                                            </td>

                                            <td class="px-4 py-3 text-sm font-medium text-gray-900 dark:text-gray-100 hover:underline">
                                                {{ $val->name }} <br>  
                                                <small>{{ $val->category->name }}</small>
                                            </td>
                                          

                                            {{-- Action --}}
                                            <td class="px-4 py-3 text-center">
                                                <div class="flex items-center justify-center gap-3">

                                                    {{-- View --}}
                                                    <a href="#"
                                                    class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </a>

                                                    {{-- Delete --}}
                                                    <a href="#"
                                                    class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300"
                                                    onclick="return confirm('Are you sure you want to delete this?')">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </a>

                                                </div>
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
                            {{-- Pagination (if used) --}}
                            @if(method_exists($subcategories, 'links'))
                            <div class="px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 border-t dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                                    {{-- LEFT --}}
                                    <div class="flex-1 min-w-0 flex items-center justify-start">
                                        @php
                                            $from  = $subcategories->firstItem() ?? 0;
                                            $to    = $subcategories->lastItem() ?? 0;
                                            $total = $subcategories->total();
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
                                        {{ $subcategories->appends(request()->query())->links() }}
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
