@php
    $isActive = function ($patterns) {
        foreach ((array) $patterns as $p) {
            if (request()->routeIs($p) || request()->is($p)) return true;
        }
        return false;
    };

    $activeDashboard = $isActive(['dashboard', '/', 'home']);

    $activeProfile = $isActive(['profile*']);

    $activeSale = $isActive([
        'sale.cart',
        'sale.cart.*',
        'sale/cart*', 
    ]);

    $activeCategory  = $isActive(['category*']);
    $activeSubCat    = $isActive(['subcategory*', 'sub-category*']);
    $activeProducts  = $isActive(['product.list', 'products*', 'product*']);

    $activeDailyReport = $isActive(['sale.report.*']);
    $activeDateWiseReport = $isActive(['date.wise.sale.report', 'date.wise.sale.report.*',]);

    $settingsOpen   = ($activeCategory || $activeSubCat || $activeProducts);
    $saleReportOpen = ($activeDailyReport || $activeDateWiseReport);
@endphp


<!-- Desktop sidebar -->
<aside class="z-20 hidden w-64 overflow-y-auto bg-white dark:bg-gray-800 md:block flex-shrink-0">
    <div class="py-4 text-gray-500 dark:text-gray-400">
        <a class="ml-6 text-lg font-bold text-gray-800 dark:text-gray-200" href="{{ url('/') }}">
            {{ $company->name }}
        </a>

        <ul class="mt-6">

            <!-- Dashboard -->
            <li class="relative px-6 py-3">
                @if($activeDashboard)
                    <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                @endif

                <a href="{{ url('/') }}"
                   class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150
                          {{ $activeDashboard ? 'text-gray-800 dark:text-gray-100' : 'text-gray-600 dark:text-gray-400' }}
                          hover:text-gray-800 dark:hover:text-gray-200">
                    <i class="fa-solid fa-house w-5 text-center"></i>
                    <span class="ml-4">Dashboard</span>
                </a>
            </li>

            <!-- Profile -->
            <li class="relative px-6 py-3">
                @if($activeProfile)
                    <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                @endif

                <a href="#"
                   class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150
                          {{ $activeProfile ? 'text-gray-800 dark:text-gray-100' : 'text-gray-600 dark:text-gray-400' }}
                          hover:text-gray-800 dark:hover:text-gray-200">
                    <i class="fa-solid fa-address-card w-5 text-center"></i>
                    <span class="ml-4">Profile</span>
                </a>
            </li>

            <!-- Sale -->
            <li class="relative px-6 py-3">
                @if($activeSale)
                    <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                @endif

                <a href="{{ route('sale.cart') }}"
                   class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150
                          {{ $activeSale ? 'text-gray-800 dark:text-gray-100' : 'text-gray-600 dark:text-gray-400' }}
                          hover:text-gray-800 dark:hover:text-gray-200">
                    <i class="fa-solid fa-cart-plus w-5 text-center"></i>
                    <span class="ml-4">Sale / Cart</span>
                </a>
            </li>

            <!-- Sale Report Dropdown -->
            <li class="relative px-6 py-3" x-data="{ open: {{ $saleReportOpen ? 'true' : 'false' }} }">
                @if($saleReportOpen)
                    <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg"></span>
                @endif

                <button
                    @click="open = !open"
                    class="inline-flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150
                        {{ $saleReportOpen ? 'text-gray-800 dark:text-gray-100' : 'text-gray-600 dark:text-gray-400' }}
                        hover:text-gray-800 dark:hover:text-gray-200"
                    aria-haspopup="true"
                    :aria-expanded="open.toString()">

                    <span class="inline-flex items-center">
                        <i class="fa-solid fa-shop w-5 text-center"></i>
                        <span class="ml-4">Sale Report</span>
                    </span>

                    <i class="fa-solid fa-chevron-down text-xs transition-transform"
                    :class="open ? 'rotate-180' : ''"></i>
                </button>

                <ul
                    x-show="open"
                    x-transition
                    x-cloak
                    class="p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium rounded-md shadow-inner
                        bg-gray-50 text-gray-500 dark:text-gray-400 dark:bg-gray-900">

                    <li class="px-2 py-1 rounded-md transition-colors duration-150
                            {{ $activeDailyReport ? 'bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100' : '' }}
                            hover:text-gray-800 dark:hover:text-gray-200">
                        <a class="block w-full" href="{{ route('sale.report.daily') }}">
                            Daily Sale Report
                        </a>
                    </li>

                    <li class="px-2 py-1 rounded-md transition-colors duration-150
                            {{ $activeDateWiseReport ? 'bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100' : '' }}
                            hover:text-gray-800 dark:hover:text-gray-200">
                        <a class="block w-full" href="{{ route('date.wise.sale.report') }}">
                            Date-wise Sales Report
                        </a>
                    </li>

                </ul>
            </li>

            <!-- Settings Dropdown -->
            <li class="relative px-6 py-3">
                @if($settingsOpen)
                    <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                @endif

                <button
                    class="inline-flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150
                           {{ $settingsOpen ? 'text-gray-800 dark:text-gray-100' : 'text-gray-600 dark:text-gray-400' }}
                           hover:text-gray-800 dark:hover:text-gray-200"
                    @click="togglePagesMenu"
                    aria-haspopup="true"
                    :aria-expanded="isPagesMenuOpen.toString()"
                    x-init="isPagesMenuOpen = {{ $settingsOpen ? 'true' : 'false' }}">

                    <span class="inline-flex items-center">
                        <i class="fa-solid fa-gear w-5 text-center"></i>
                        <span class="ml-4">Settings</span>
                    </span>

                    <i class="fa-solid fa-chevron-down text-xs"></i>
                </button>

                <ul
                    x-show="isPagesMenuOpen"
                    x-transition:enter="transition-all ease-in-out duration-300"
                    x-transition:enter-start="opacity-0 max-h-0"
                    x-transition:enter-end="opacity-100 max-h-xl"
                    x-transition:leave="transition-all ease-in-out duration-300"
                    x-transition:leave-start="opacity-100 max-h-xl"
                    x-transition:leave-end="opacity-0 max-h-0"
                    class="p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium rounded-md shadow-inner
                           bg-gray-50 text-gray-500 dark:text-gray-400 dark:bg-gray-900"
                    aria-label="submenu">

                    <li class="px-2 py-1 rounded-md transition-colors duration-150
                               {{ $activeCategory ? 'bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100' : '' }}
                               hover:text-gray-800 dark:hover:text-gray-200">
                        <a class="w-full block" href="{{ route('category.list') }}">
                            Category
                        </a>
                    </li>

                    <li class="px-2 py-1 rounded-md transition-colors duration-150
                               {{ $activeSubCat ? 'bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100' : '' }}
                               hover:text-gray-800 dark:hover:text-gray-200">
                        <a class="w-full block" href="{{ route('subcategory.list') }}">
                            Sub-category
                        </a>
                    </li>

                    <li class="px-2 py-1 rounded-md transition-colors duration-150
                               {{ $activeProducts ? 'bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100' : '' }}
                               hover:text-gray-800 dark:hover:text-gray-200">
                        <a class="w-full block" href="{{ route('product.list') }}">
                            Products
                        </a>
                    </li>
                </ul>
            </li>
        </ul>

        <div class="px-6 my-6">
            <button class="flex items-center justify-between w-full px-4 py-2 text-sm font-medium leading-5 text-white
                           transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg
                           active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                Create account
                <span class="ml-2" aria-hidden="true">+</span>
            </button>
        </div>
    </div>
</aside>









<!-- Mobile sidebar Backdrop -->
<div
    x-show="isSideMenuOpen"
    x-transition:enter="transition ease-in-out duration-150"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in-out duration-150"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-10 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center">
</div>










<!-- Mobile sidebar -->
<aside
    class="fixed inset-y-0 z-20 flex-shrink-0 w-64 mt-16 overflow-y-auto bg-white dark:bg-gray-800 md:hidden"
    x-show="isSideMenuOpen"
    x-transition:enter="transition ease-in-out duration-150"
    x-transition:enter-start="opacity-0 transform -translate-x-20"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in-out duration-150"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0 transform -translate-x-20"
    @click.away="closeSideMenu"
    @keydown.escape="closeSideMenu">

    <div class="py-4 text-gray-500 dark:text-gray-400">
        <a class="ml-6 text-lg font-bold text-gray-800 dark:text-gray-200" href="{{ url('/') }}">
            SAMIM-STATIONARY
        </a>

        <ul class="mt-6">

            <!-- Dashboard -->
            <li class="relative px-6 py-3">
                @if($activeDashboard)
                    <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                @endif

                <a href="{{ url('/') }}"
                   class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150
                          {{ $activeDashboard ? 'text-gray-800 dark:text-gray-100' : 'text-gray-600 dark:text-gray-400' }}
                          hover:text-gray-800 dark:hover:text-gray-200">
                    <i class="fa-solid fa-house w-5 text-center"></i>
                    <span class="ml-4">Dashboard</span>
                </a>
            </li>

            <!-- Profile -->
            <li class="relative px-6 py-3">
                @if($activeProfile)
                    <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                @endif

                <a href="#"
                   class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150
                          {{ $activeProfile ? 'text-gray-800 dark:text-gray-100' : 'text-gray-600 dark:text-gray-400' }}
                          hover:text-gray-800 dark:hover:text-gray-200">
                    <i class="fa-solid fa-address-card w-5 text-center"></i>
                    <span class="ml-4">Profile</span>
                </a>
            </li>

            <!-- Sale Cart -->
            <li class="relative px-6 py-3">
                @if($activeSale)
                    <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                @endif

                <a href="{{ route('sale.cart') }}"
                   class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150
                          {{ $activeSale ? 'text-gray-800 dark:text-gray-100' : 'text-gray-600 dark:text-gray-400' }}
                          hover:text-gray-800 dark:hover:text-gray-200">
                    <i class="fa-solid fa-cart-plus w-5 text-center"></i>
                    <span class="ml-4">Sale / Cart</span>
                </a>
            </li>


            <!-- Report Dropdown -->
            <li class="relative px-6 py-3"
                x-data="{ reportOpen: {{ $saleReportOpen ? 'true' : 'false' }} }">

                @if($saleReportOpen)
                    <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                @endif

                <button
                    class="inline-flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150
                        {{ $saleReportOpen ? 'text-gray-800 dark:text-gray-100' : 'text-gray-600 dark:text-gray-400' }}
                        hover:text-gray-800 dark:hover:text-gray-200"
                    @click="reportOpen = !reportOpen"
                    aria-haspopup="true"
                    :aria-expanded="reportOpen.toString()">

                    <span class="inline-flex items-center">
                        <i class="fa-solid fa-shop w-5 text-center"></i>
                        <span class="ml-4">Sale Report</span>
                    </span>

                    <i class="fa-solid fa-chevron-down text-xs transition-transform"
                    :class="reportOpen ? 'rotate-180' : ''"></i>
                </button>

                <ul
                    x-show="reportOpen"
                    x-transition:enter="transition-all ease-in-out duration-300"
                    x-transition:enter-start="opacity-0 max-h-0"
                    x-transition:enter-end="opacity-100 max-h-xl"
                    x-transition:leave="transition-all ease-in-out duration-300"
                    x-transition:leave-start="opacity-100 max-h-xl"
                    x-transition:leave-end="opacity-0 max-h-0"
                    x-cloak
                    class="p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium rounded-md shadow-inner
                        bg-gray-50 text-gray-500 dark:text-gray-400 dark:bg-gray-900"
                    aria-label="submenu">

                    <li class="px-2 py-1 rounded-md transition-colors duration-150
                            {{ $activeDailyReport ? 'bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100' : '' }}
                            hover:text-gray-800 dark:hover:text-gray-200">
                        <a class="w-full block" href="{{ route('sale.report.daily') }}">
                            Daily Sale Report
                        </a>
                    </li>

                    <li class="px-2 py-1 rounded-md transition-colors duration-150
                            {{ $activeDateWiseReport ? 'bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100' : '' }}
                            hover:text-gray-800 dark:hover:text-gray-200">
                        <a class="w-full block" href="{{ route('date.wise.sale.report') }}">
                            Daily Sale Report
                        </a>
                    </li>

                </ul>
            </li>

            <!-- Settings Dropdown -->
            <li class="relative px-6 py-3">
                @if($settingsOpen)
                    <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                @endif

                <button
                    class="inline-flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150
                           {{ $settingsOpen ? 'text-gray-800 dark:text-gray-100' : 'text-gray-600 dark:text-gray-400' }}
                           hover:text-gray-800 dark:hover:text-gray-200"
                    @click="togglePagesMenu"
                    aria-haspopup="true"
                    :aria-expanded="isPagesMenuOpen.toString()"
                    x-init="isPagesMenuOpen = {{ $settingsOpen ? 'true' : 'false' }}">

                    <span class="inline-flex items-center">
                        <i class="fa-solid fa-gear w-5 text-center"></i>
                        <span class="ml-4">Settings</span>
                    </span>

                    <i class="fa-solid fa-chevron-down text-xs"></i>
                </button>

                <ul
                    x-show="isPagesMenuOpen"
                    x-transition:enter="transition-all ease-in-out duration-300"
                    x-transition:enter-start="opacity-0 max-h-0"
                    x-transition:enter-end="opacity-100 max-h-xl"
                    x-transition:leave="transition-all ease-in-out duration-300"
                    x-transition:leave-start="opacity-100 max-h-xl"
                    x-transition:leave-end="opacity-0 max-h-0"
                    class="p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium rounded-md shadow-inner
                           bg-gray-50 text-gray-500 dark:text-gray-400 dark:bg-gray-900"
                    aria-label="submenu">

                    <li class="px-2 py-1 rounded-md transition-colors duration-150
                               {{ $activeCategory ? 'bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100' : '' }}
                               hover:text-gray-800 dark:hover:text-gray-200">
                        <a class="w-full block" href="{{ route('category.list') }}">Category</a>
                    </li>

                    <li class="px-2 py-1 rounded-md transition-colors duration-150
                               {{ $activeSubCat ? 'bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100' : '' }}
                               hover:text-gray-800 dark:hover:text-gray-200">
                        <a class="w-full block" href="{{ route('subcategory.list') }}">Sub-Category</a>
                    </li>

                    <li class="px-2 py-1 rounded-md transition-colors duration-150
                               {{ $activeProducts ? 'bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100' : '' }}
                               hover:text-gray-800 dark:hover:text-gray-200">
                        <a class="w-full block" href="{{ route('product.list') }}">Products</a>
                    </li>
                </ul>
            </li>

        </ul>

        <div class="px-6 my-6">
            <button class="flex items-center justify-between w-full px-4 py-2 text-sm font-medium leading-5 text-white
                           transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg
                           active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                Create account
                <span class="ml-2" aria-hidden="true">+</span>
            </button>
        </div>
    </div>
</aside>
