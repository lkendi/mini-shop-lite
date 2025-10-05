@extends('layouts.app')

@section('title', 'MiniShop Lite - Your Modern Store Solution')

@section('hero')
    <section class="relative bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900 overflow-hidden text-white">
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-40 -right-32 w-80 h-80 bg-purple-500/10 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-40 -left-32 w-80 h-80 bg-blue-500/10 rounded-full blur-3xl"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 md:py-32">
            <div class="text-center space-y-8">
                <div class="space-y-4">
                    <h1 class="text-5xl lg:text-7xl font-bold tracking-tight drop-shadow-lg">
                        <span class="bg-gradient-to-r from-white via-blue-100 to-purple-200 bg-clip-text text-transparent">
                            Quality Products,
                        </span>
                        <br>
                        <span class="bg-gradient-to-r from-purple-300 via-pink-300 to-blue-300 bg-clip-text text-transparent">
                            Happy You
                        </span>
                    </h1>
                </div>

                <p class="max-w-2xl mx-auto text-lg md:text-xl text-blue-100/90 leading-relaxed">
                    Discover a curated collection of products that inspire and elevate your everyday life.
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                    <a href="#featured" 
                    class="bg-white text-slate-900 px-8 py-4 rounded-xl font-semibold text-lg transition-all duration-300 hover:scale-105 hover:shadow-2xl hover:shadow-white/20 hero-cta-primary" style="min-height:56px; display:inline-flex; align-items:center; justify-content:center;">
                        Explore Products
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('content')
    <section id="featured" class="py-20 bg-white dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white">Featured Products</h2>
                <p class="mt-4 text-lg text-gray-600 dark:text-gray-400">Handpicked items that combine style, functionality, and value.</p>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse($featuredProducts as $product)
                    @include('products.partials.card', ['product' => $product])
                @empty
                    <div class="col-span-full text-center py-12">
                        <x-heroicon-o-exclamation-triangle class="mx-auto h-12 w-12 text-gray-400" />
                        <h3 class="mt-2 text-lg font-medium text-gray-900 dark:text-white">No featured products available</h3>
                        <p class="mt-1 text-gray-500 dark:text-gray-400">Check back later for new arrivals.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <section id="categories" class="py-20 bg-gray-100 dark:bg-gray-800">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white">
                    Shop by Category
                </h2>
                <p class="mt-3 text-lg text-gray-600 dark:text-gray-400">
                    Discover collections tailored for you
                </p>
            </div>

            <div class="flex flex-wrap justify-center gap-8">
                @foreach($categories as $category)
                <a href="#" 
                class="flex-none w-32 group text-center transform hover:scale-105 transition-transform duration-300">
                    <div class="w-32 h-32 mx-auto rounded-full bg-gradient-to-br from-blue-100 to-blue-200 dark:from-blue-800 dark:to-blue-700 flex items-center justify-center shadow-md group-hover:shadow-lg transition-shadow duration-300">
                        <x-heroicon-o-tag class="w-10 h-10 text-blue-700 dark:text-blue-300" />
                    </div>

                    <h3 class="mt-4 font-medium text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors duration-300">
                        {{ $category }}
                    </h3>
                </a>
                @endforeach
            </div>
        </div>
    </section>

    <section class="py-12 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h3 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">Looking for something else?</h3>
            <p class="text-gray-600 dark:text-gray-300 mb-6">Browse our full catalog to discover more products and exclusive deals.</p>
            <a href="{{ route('products.index') }}" 
                class="inline-block hero-cta-primary bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold shadow transition-all duration-300 
                         hover:shadow-[0_0_20px_5px_rgba(59,130,246,0.5)] hover:scale-105">
                 Browse all products
            </a>
        </div>
    </section>
@endsection
