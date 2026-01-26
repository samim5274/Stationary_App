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
                            Sale / Cart
                        </h2>

                        {{-- RIGHT : Action Button --}}
                        <a href="{{ route('product.list') }}"
                        class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium
                                text-white bg-blue-600 rounded-lg
                                hover:bg-blue-700 transition
                                focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2
                                dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-offset-gray-800">
                            <i class="fa-solid fa-plus mr-2"></i>
                            Product's
                        </a>
                    </div>


                    @include('layouts.message')

                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 lg:gap-6 mb-8">

                        @include('cart.cart-body')

                    </div>


                </div>
            </main>

        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <script src="{{ asset('assets/js/init-alpine.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>window.CART_UPDATE_URL = "{{ route('cart.updateQty') }}";</script>
    <script src="{{ asset('assets/js/cart.js') }}"></script>
    <script src="{{ asset('assets/js/order.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const isSuccess = @json(session()->has('success'));
            const reg = @json(session('reg'));

            if (isSuccess && reg) {
                const printUrl = "{{ route('order-print', ':reg') }}".replace(':reg', reg);
                window.open(printUrl, '_blank');
            }
        });
    </script>

</body>
</html>
