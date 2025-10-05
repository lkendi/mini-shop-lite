@extends('layouts.app')

@section('title', 'All Products - MiniShop Lite')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-900 dark:text-white">All Products</h1>
            <p class="mt-2 text-lg text-gray-600 dark:text-gray-400">Explore our full range of curated products.</p>
        </div>

        <x-filters :action="route('products.index')" :categories="$categories" />
        @if(request()->has('search') || request()->has('category') || request()->has('sort'))
        <div class="mb-6">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Showing {{ $products->count() }} of {{ $products->total() }} products
                @if(request('search')) matching "{{ request('search') }}"@endif
                @if(request('category') && request('category') !== 'all') in {{ request('category') }}@endif
            </p>
        </div>
        @endif

        @if($products->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($products as $product)
                    @include('products.partials.card', ['product' => $product])
                @endforeach
            </div>

            <div class="mt-12">
                {{ $products->links() }}
            </div>
        @else
            <div class="text-center py-16 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                <x-heroicon-o-exclamation-triangle class="mx-auto h-16 w-16 text-gray-400" />
                <h3 class="mt-4 text-xl font-semibold text-gray-900 dark:text-white">No Products Found</h3>
                <p class="mt-2 text-gray-600 dark:text-gray-400">Sorry, we couldn't find any products matching your criteria.</p>
                <div class="mt-6">
                    <a href="{{ route('products.index') }}" 
                       class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200">
                        Clear filters and view all products
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

    @push('scripts')
    <script>
        let searchTimeout;
        function debounce(form, delay = 200) {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                form.submit();
            }, delay);
        }
    </script>
    @endpush
