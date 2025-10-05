@extends('layouts.app')

@section('content')
    <div class="bg-gray-100 dark:bg-gray-900">
        <div class="bg-white dark:bg-gray-800 shadow-md">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            </div>
        </div>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 flex items-center space-x-4">
                        <div class="bg-blue-100 dark:bg-blue-900/50 p-3 rounded-full">
                            <x-heroicon-o-cube class="w-6 h-6 text-blue-600 dark:text-blue-400" />
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Total Products</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $totalProducts }}</p>
                        </div>
                    </div>


                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 flex items-center space-x-4">
                        <div class="bg-green-100 dark:bg-green-900/50 p-3 rounded-full">
                            <x-heroicon-o-currency-dollar class="w-6 h-6 text-green-600 dark:text-green-400" />
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Total Sales</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">${{ number_format($totalSales, 2) }}</p>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 flex items-center space-x-4">
                        <div class="bg-yellow-100 dark:bg-yellow-900/50 p-3 rounded-full">
                            <x-heroicon-o-shopping-cart class="w-6 h-6 text-yellow-600 dark:text-yellow-400" />
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">New Orders</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $newOrders }}</p>
                        </div>
                    </div>

 
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 flex items-center space-x-4">
                        <div class="bg-purple-100 dark:bg-purple-900/50 p-3 rounded-full">
                            <x-heroicon-o-users class="w-6 h-6 text-purple-600 dark:text-purple-400" />
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Total Customers</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $totalCustomers }}</p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 h-80">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Products by Category</h3>
                        <div style="position: relative; height: 85%; width: 100%;"><canvas id="productsByCategoryChart"></canvas></div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 h-80">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Sales by Category</h3>
                        <div style="position: relative; height: 85%; width: 100%;"><canvas id="salesByCategoryChart"></canvas></div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <a href="{{ route('admin.products.index') }}" class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 text-center hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                        <x-heroicon-o-cube class="w-10 h-10 mx-auto text-blue-500 dark:text-blue-400 mb-3" />
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Manage Products</h3>
                        <p class="mt-2 text-gray-600 dark:text-gray-400">Add, edit, and delete products.</p>
                    </a>
                    <a href="#" class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 text-center hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                        <x-heroicon-o-shopping-bag class="w-10 h-10 mx-auto text-green-500 dark:text-green-400 mb-3" />
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Manage Orders</h3>
                        <p class="mt-2 text-gray-600 dark:text-gray-400">View customer orders.</p>
                    </a>
                    <a href="{{ route('admin.customers.index') }}" class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 text-center hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                        <x-heroicon-o-users class="w-10 h-10 mx-auto text-purple-500 dark:text-purple-400 mb-3" />
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Manage Customers</h3>
                        <p class="mt-2 text-gray-600 dark:text-gray-400">Manage customer accounts.</p>
                    </a>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const productsByCategoryLabels = @json($productsByCategory->pluck('category'));
            const productsByCategoryData = @json($productsByCategory->pluck('product_count'));

            const salesByCategoryLabels = @json($salesByCategory->pluck('category'));
            const salesByCategoryData = @json($salesByCategory->pluck('total_sales'));
        </script>
        <script src="{{ asset('js/admin-dashboard.js') }}"></script>
    @endpush
@endsection
