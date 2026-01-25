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
                            Edit {{ $category->name }} Category
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

                    {{-- Table --}}
                    <div class="grid gap-6 mb-8 md:grid-cols-1">
                        

                        <div class="w-full overflow-hidden rounded-xl bg-white shadow-sm
                                dark:bg-gray-800 dark:border dark:border-gray-700">

                            {{-- Header --}}
                            <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700">
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    Add a new product category to organize your items.
                                </p>
                            </div>

                            {{-- Form --}}
                            <form action="{{ route('category.modify', $category->id) }}" method="POST" class="px-6 py-6 space-y-6">
                                @csrf
                                @method('PUT')
                                
                                {{-- Category Name --}}
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1">
                                        Category Name <span class="text-red-500">*</span>
                                    </label>

                                    <input
                                        type="text"
                                        name="name"
                                        value="{{ old('name', $category->name) }}"
                                        placeholder="e.g. Stationary"
                                        required
                                        class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm
                                            text-gray-700 placeholder-gray-400
                                            focus:border-purple-500 focus:outline-none focus:ring-2 focus:ring-purple-200
                                            dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200
                                            dark:placeholder-gray-400 dark:focus:ring-purple-900">
                                </div>

                                {{-- Footer --}}
                                <div class="flex flex-col-reverse gap-3 sm:flex-row sm:items-center sm:justify-end pt-4 border-t
                                            border-gray-100 dark:border-gray-700">

                                    <a href="{{ url()->previous() }}"
                                    class="inline-flex items-center justify-center rounded-lg px-5 py-2.5 text-sm font-semibold
                                            bg-gray-100 text-gray-700 hover:bg-gray-200
                                            dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600">
                                        <i class="fa-solid fa-arrow-left mr-2"></i>
                                        Back
                                    </a>

                                    <button type="submit" onclick="return confirm('Create this category?');"
                                            class="inline-flex items-center justify-center rounded-lg px-5 py-2.5 text-sm font-semibold
                                                text-white bg-purple-600 hover:bg-purple-700
                                                focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2
                                                dark:focus:ring-offset-gray-800">
                                        <i class="fa-solid fa-floppy-disk mr-2"></i>
                                        Save Category
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
