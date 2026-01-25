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
                            Sub-Category Details
                        </h2>

                        {{-- RIGHT : Action Button --}}
                        <!-- <a href="#"
                        class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium
                                text-white bg-blue-600 rounded-lg
                                hover:bg-blue-700 transition
                                focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2
                                dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-offset-gray-800">
                            <i class="fa-solid fa-plus mr-2"></i>
                            Add New Category
                        </a> -->
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
                            <p class="mb-1 text-sm font-medium text-gray-500 dark:text-gray-400">Total Category</p>
                            <p class="text-xl font-bold text-gray-800 dark:text-gray-100">{{ number_format($subcategories->total()) }}</p>
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
                    <div class="grid gap-6 mb-8 md:grid-cols-2">
                        <div class="w-full overflow-hidden rounded-lg shadow-xs">

                            <div class="w-full overflow-x-auto">
                                <table class="w-full whitespace-nowrap">
                                    <thead>
                                        <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b
                                                dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                            <th class="px-4 py-3">Subcategory</th>
                                            <th class="px-4 py-3">Category</th>
                                            <th class="px-4 py-3">Created</th>
                                            <th class="px-4 py-3 text-right">Action</th>
                                        </tr>
                                    </thead>

                                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                                        @forelse($subcategories as $s)
                                            <tr class="group
                                                    text-gray-700 dark:text-gray-300
                                                    hover:bg-gray-50 hover:text-gray-900
                                                    dark:hover:bg-gray-700/50 dark:hover:text-gray-100
                                                    transition">

                                                {{-- Subcategory --}}
                                                <td class="px-4 py-3">
                                                    <div class="flex items-center gap-3">

                                                        {{-- Avatar --}}
                                                        <div class="w-10 h-10 rounded-full flex items-center justify-center
                                                                    bg-purple-100 text-purple-700 font-extrabold uppercase
                                                                    dark:bg-purple-700 dark:text-purple-100
                                                                    group-hover:bg-purple-200 dark:group-hover:bg-purple-600
                                                                    transition">
                                                            {{ strtoupper(substr($s->name ?? 'S', 0, 1)) }}
                                                        </div>

                                                        {{-- Name + ID --}}
                                                        <div>
                                                            <p class="text-sm font-semibold
                                                                    text-gray-700 dark:text-gray-200
                                                                    group-hover:text-gray-900 dark:group-hover:text-gray-100">
                                                                {{ $s->name }}
                                                            </p>

                                                            <p class="text-xs
                                                                    text-gray-500 dark:text-gray-400
                                                                    group-hover:text-gray-700 dark:group-hover:text-gray-300">
                                                                ID: <span class="font-semibold">{{ $s->id }}</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </td>

                                                {{-- Parent Category --}}
                                                <td class="px-4 py-3 text-sm">
                                                    <span class="inline-flex items-center px-2.5 py-1 text-xs font-semibold rounded-full
                                                            text-blue-700 dark:bg-blue-900/40 dark:text-blue-300
                                                            dark:border-blue-700 group-hover:bg-blue-200 group-hover:text-blue-800
                                                            dark:group-hover:bg-blue-800/60 dark:group-hover:text-blue-200
                                                            transition">
                                                        {{ $s->category?->name ?? '—' }}
                                                    </span>

                                                </td>

                                                {{-- Created --}}
                                                <td class="px-4 py-3 text-sm
                                                        text-gray-600 dark:text-gray-400
                                                        group-hover:text-gray-800 dark:group-hover:text-gray-200">
                                                    {{ optional($s->created_at)->format('d M Y') ?? '—' }}
                                                </td>

                                                {{-- Action --}}
                                                <td class="px-4 py-3">
                                                    <div class="flex items-center justify-end space-x-2">

                                                        {{-- Edit --}}
                                                        <a href="{{ route('subcategory.edit', $s->id) }}"
                                                        class="p-2 rounded-lg
                                                                text-gray-600 dark:text-gray-300
                                                                hover:bg-gray-100 hover:text-gray-900
                                                                dark:hover:bg-gray-700 dark:hover:text-gray-100
                                                                transition"
                                                        title="Edit">
                                                            <i class="fa-regular fa-pen-to-square"></i>
                                                        </a>

                                                        {{-- Delete --}}
                                                        <form action="{{ route('subcategory.delete', $s->id) }}" method="POST"
                                                            onsubmit="return confirm('Delete this subcategory?');">
                                                            @csrf
                                                            @method('DELETE')

                                                            <button type="submit"
                                                                    class="p-2 rounded-lg
                                                                        text-red-600
                                                                        hover:bg-red-50
                                                                        dark:hover:bg-red-900/30
                                                                        transition"
                                                                    title="Delete">
                                                                <i class="fa-regular fa-trash-can"></i>
                                                            </button>
                                                        </form>

                                                    </div>
                                                </td>

                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="px-4 py-6 text-center text-sm text-gray-500 dark:text-gray-400">
                                                    No subcategories found.
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
                        </div>

                        <div class="w-full overflow-hidden rounded-xl bg-white shadow-sm
                                dark:bg-gray-800 dark:border dark:border-gray-700">

                            {{-- Header --}}
                            <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700">
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    Add a new product Sub-category to organize your items.
                                </p>
                            </div>

                            {{-- Form --}}
                            <form action="{{ route('subcategory.create') }}" method="POST"
                                class="px-6 py-6 space-y-6 bg-white dark:bg-gray-800 rounded-lg">
                                @csrf

                                {{-- Category --}}
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1">
                                        Category <span class="text-red-500">*</span>
                                    </label>

                                    <select name="category_id"
                                            class="block w-full rounded-lg border px-4 py-2.5 text-sm
                                                bg-white text-gray-700
                                                border-gray-300
                                                focus:border-purple-500 focus:outline-none focus:ring-2 focus:ring-purple-200
                                                dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600
                                                dark:focus:ring-purple-900">
                                        <option value="" disabled {{ old('category_id') ? '' : 'selected' }}>-- Select Category --</option>

                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('category_id')
                                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Subcategory Name --}}
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1">
                                        Sub-Category Name <span class="text-red-500">*</span>
                                    </label>

                                    <input type="text"
                                        name="name"
                                        value="{{ old('name') }}"
                                        placeholder="e.g. A4 Paper / Stationary / Ink"
                                        required
                                        class="block w-full rounded-lg border px-4 py-2.5 text-sm
                                                bg-white text-gray-700 placeholder-gray-400
                                                border-gray-300
                                                focus:border-purple-500 focus:outline-none focus:ring-2 focus:ring-purple-200
                                                dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600
                                                dark:placeholder-gray-400 dark:focus:ring-purple-900">

                                    @error('name')
                                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Footer --}}
                                <div class="flex flex-col-reverse gap-3 sm:flex-row sm:items-center sm:justify-end pt-4 border-t
                                            border-gray-100 dark:border-gray-700">

                                    <a href="{{ url()->previous() }}"
                                    class="inline-flex items-center justify-center rounded-lg px-5 py-2.5 text-sm font-semibold
                                            bg-gray-100 text-gray-700 hover:bg-gray-200
                                            dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600 transition">
                                        <i class="fa-solid fa-arrow-left mr-2"></i> Back
                                    </a>

                                    <button type="submit"
                                            class="inline-flex items-center justify-center rounded-lg px-5 py-2.5 text-sm font-semibold
                                                text-white bg-purple-600 hover:bg-purple-700
                                                focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2
                                                dark:focus:ring-offset-gray-800 transition">
                                        <i class="fa-solid fa-floppy-disk mr-2"></i> Save Subcategory
                                    </button>
                                </div>
                            </form>

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
