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
                           Expenses Details - <small>Total: ৳ {{ $expensess->sum('amount') }}/-</small>
                        </h2>

                        {{-- RIGHT : Action Button --}}
                        <a href="#"
                        class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium
                                text-white bg-blue-600 rounded-lg
                                hover:bg-blue-700 transition
                                focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2
                                dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-offset-gray-800">
                            <i class="fa-solid fa-gear mr-2"></i>
                            Setting
                        </a>
                    </div>


                    @include('layouts.message')

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-6 mb-8">

                        <form action="{{ route('create.expenses') }}" method="POST" class="px-6 py-6 bg-white dark:bg-gray-800 rounded-xl shadow-md space-y-5">
                            @csrf

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
                                    Title <span class="text-red-500">*</span>
                                </label>
                                <input name="title" type="text" required                                    
                                    class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 text-md
                                            bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100
                                            focus:outline-none focus:ring-2 focus:ring-indigo-300 dark:focus:ring-indigo-500"
                                    placeholder="Enter expense title">
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="text-sm font-medium text-gray-700 dark:text-gray-200 mb-1 block">
                                        Category <span class="text-red-500">*</span>
                                    </label>
                                    <select name="category_id" id="category_id" required
                                            data-selected="{{ old('category_id', $expense->category_id ?? '') }}"
                                            class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2
                                                bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100
                                                focus:ring-2 focus:ring-indigo-300 dark:focus:ring-indigo-500 focus:outline-none">
                                        <option value="" disabled selected>
                                            -- Select Category --
                                        </option>
                                        @foreach($categories as $val)
                                            <option value="{{ $val->id }}">
                                                {{ $val->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-700 dark:text-gray-200 mb-1 block">
                                        Sub Category <span class="text-red-500">*</span>
                                    </label>
                                    <select name="subcategory_id" id="subcategory_id" required
                                            
                                            class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2
                                                bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100
                                                focus:ring-2 focus:ring-indigo-300 dark:focus:ring-indigo-500 focus:outline-none">
                                        <option value="" disabled selected>-- Select Sub Category --</option>
                                    </select>
                                </div>

                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-700 dark:text-gray-200 mb-1 block">
                                    Description (optional)
                                </label>
                                <textarea name="description" rows="4"
                                        class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2
                                                bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100
                                                focus:ring-2 focus:ring-indigo-300 dark:focus:ring-indigo-500 focus:outline-none"
                                        placeholder="Enter expense details"></textarea>
                            </div>

                            {{-- Amount --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
                                    Amount <span class="text-red-500">*</span>
                                </label>
                                <input name="amount" type="number" min="0" required
                                    value="{{ old('amount', $expense->amount ?? '') }}"
                                    class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2
                                            bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100
                                            focus:outline-none focus:ring-2 focus:ring-indigo-300 dark:focus:ring-indigo-500"
                                    placeholder="Enter expense amount">
                            </div>

                            {{-- Submit --}}
                            <div>
                                <button type="submit"
                                        class="w-full bg-[#3F4D67] text-white py-2.5 rounded-lg text-sm font-semibold
                                            hover:bg-[#6d85b1] transition duration-200 shadow">
                                    Save Expense
                                </button>
                            </div>

                        </form>

                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow overflow-x-auto border border-gray-100 dark:border-gray-700">

                            <table class="min-w-full text-sm">
                                <thead class="bg-gray-100 dark:bg-gray-800">
                                    <tr>
                                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 dark:text-gray-200 uppercase">#</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-200 uppercase">Title</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-200 uppercase">Amount</th>
                                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 dark:text-gray-200 uppercase">Action</th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200">
                                    @forelse($expensess as $i => $val)
                                        <tr class="transition-colors duration-150
                                                bg-white dark:bg-gray-900
                                                hover:bg-gray-50 dark:hover:bg-gray-800">

                                            <td class="px-4 py-3 text-center text-sm text-gray-700 dark:text-gray-200">
                                                {{ $loop->iteration }}
                                            </td>

                                            <td class="px-4 py-3 text-sm font-medium text-gray-900 dark:text-gray-100 hover:underline">
                                                <a href="{{ route('expenses-view-details', $val->id) }}">
                                                    {{ $val->title }} <br> 
                                                    <small>{{ $val->category->name ?? 'N/A' }}</small> -  
                                                    <small>{{ $val->subcategory->name ?? 'N/A' }}</small> <br>
                                                    <small>{{ \Carbon\Carbon::parse($val->date)->format('d M, Y') }}</small>
                                                </a>
                                            </td>

                                            <td class="px-4 py-3 text-sm font-semibold text-gray-900 dark:text-gray-100">
                                                ৳ {{ number_format($val->amount, 2) }}/-
                                            </td>

                                            {{-- Action --}}
                                            <td class="px-4 py-3 text-center">
                                                <div class="flex items-center justify-center gap-3">

                                                    {{-- View --}}
                                                    <a href="{{ route('expenses-view-details', $val->id) }}"
                                                    class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                                        <i class="fa-solid fa-eye"></i>
                                                    </a>

                                                    {{-- Print --}}
                                                    <a href="{{ route('expenses.print', $val->id) }}" target="_blank"
                                                    class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                                        <i class="fa-solid fa-print"></i>
                                                    </a>

                                                    {{-- Delete --}}
                                                    <a href="{{ route('expenses-delete', $val->id) }}"
                                                    class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300"
                                                    onclick="return confirm('Are you sure you want to delete this Expense?')">
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
                            @if(method_exists($expensess, 'links'))
                            <div class="px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 border-t dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                                    {{-- LEFT --}}
                                    <div class="flex-1 min-w-0 flex items-center justify-start">
                                        @php
                                            $from  = $expensess->firstItem() ?? 0;
                                            $to    = $expensess->lastItem() ?? 0;
                                            $total = $expensess->total();
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
                                        {{ $expensess->appends(request()->query())->links() }}
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
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
        $(document).ready(function() {

            $('#category_id').on('change', function() {

                let categoryId = $(this).val();
                $('#subcategory_id').html('<option value="">Loading...</option>');

                if (categoryId) {
                    $.ajax({
                        url: '/expenses/get-subcategories/' + categoryId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {

                            let options = '<option value="" selected disabled>-- Select Sub Category --</option>';

                            if (data.length > 0) {
                                $.each(data, function(index, value) {
                                    options += `<option value="${value.id}">${value.name}</option>`;
                                });
                            } else {
                                options += '<option value="">No subcategory found</option>';
                            }

                            $('#subcategory_id').html(options);
                        },
                        error: function(xhr) {
                            console.log(xhr.responseText);
                            $('#subcategory_id').html('<option value="">Failed to load</option>');
                        }
                    });
                } else {
                    $('#subcategory_id').html('<option value="">-- Select Sub Category --</option>');
                }

            });

        });
    </script>


</body>
</html>
