@extends('layouts.app')

@section('title', 'Products')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-[#2C3E50] mb-4">Electronic Components & Development Boards</h1>
        <p class="text-gray-600">Discover our wide range of microcontrollers, sensors, and electronic components for your next project.</p>
    </div>

    <!-- Filters Section -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <form action="{{ route('products.index') }}" method="GET" class="flex flex-wrap gap-4">
            <!-- Search (mobile) -->
            <div class="flex-1 min-w-64 md:hidden">
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Search products..." 
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#2980B9]">
            </div>

            <!-- Category Filter -->
            <div class="flex-1 min-w-48">
                <select name="category" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#2980B9]">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Sort Filter -->
            <div class="flex-1 min-w-48">
                <select name="sort" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#2980B9]">
                    <option value="">Sort by Latest</option>
                    <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                    <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name A-Z</option>
                </select>
            </div>

            <!-- Filter Button -->
            <button type="submit" class="bg-[#2980B9] text-white px-6 py-2 rounded-lg hover:bg-opacity-90 transition-colors">
                Apply Filters
            </button>

            <!-- Clear Filters -->
            @if(request()->hasAny(['search', 'category', 'sort']))
                <a href="{{ route('products.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-opacity-90 transition-colors">
                    Clear
                </a>
            @endif
        </form>
    </div>

    <!-- Results Info -->
    <div class="flex justify-between items-center mb-6">
        <p class="text-gray-600">
            Showing {{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }} of {{ $products->total() }} products
        </p>
    </div>

    <!-- Products Grid -->
    @if($products->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-12">
            @foreach($products as $product)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                    <!-- Product Image -->
                    <div class="h-48 bg-gray-200 flex items-center justify-center">
                        @if($product->image)
                            <img src="{{ asset('images/' . $product->image) }}" 
                                 alt="{{ $product->name }}" 
                                 class="max-h-full max-w-full object-contain">
                        @else
                            <div class="text-gray-400 text-center">
                                <svg class="mx-auto h-16 w-16 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                                </svg>
                                <p class="text-sm">No Image</p>
                            </div>
                        @endif
                    </div>

                    <!-- Product Info -->
                    <div class="p-4">
                        <!-- Category Badge -->
                        <div class="mb-2">
                            <span class="inline-block bg-[#2980B9] text-white text-xs px-2 py-1 rounded-full">
                                {{ $product->category->name }}
                            </span>
                        </div>

                        <!-- Product Name -->
                        <h3 class="font-semibold text-gray-800 mb-2 h-12 flex items-center">
                            {{ $product->name }}
                        </h3>

                        <!-- Product Description -->
                        <p class="text-gray-600 text-sm mb-3 h-16 overflow-hidden">
                            {{ Str::limit($product->description, 80) }}
                        </p>

                        <!-- Price and Stock -->
                        <div class="flex justify-between items-center mb-3">
                            <span class="text-2xl font-bold text-[#27AE60]">${{ number_format($product->price, 2) }}</span>
                            <span class="text-sm text-gray-500">
                                Stock: {{ $product->stock }}
                            </span>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex space-x-2">
                            <a href="{{ route('products.show', $product) }}" 
                               class="flex-1 bg-[#2C3E50] text-white text-center py-2 px-4 rounded-lg hover:bg-opacity-90 transition-colors text-sm">
                                View Details
                            </a>
                            @auth
                                @if(!auth()->user()->is_admin)
                                    @if($product->stock > 0)
                                        <form action="{{ route('cart.store') }}" method="POST" class="flex-1">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" 
                                                    class="w-full bg-[#27AE60] text-white py-2 px-4 rounded-lg hover:bg-opacity-90 transition-colors text-sm">
                                                Add to Cart
                                            </button>
                                        </form>
                                    @else
                                        <button disabled 
                                                class="flex-1 bg-gray-400 text-white py-2 px-4 rounded-lg cursor-not-allowed text-sm">
                                            Out of Stock
                                        </button>
                                    @endif
                                @endif
                            @endauth
                            @guest
                                <a href="{{ route('login') }}" class="flex-1 bg-[#2980B9] text-white text-center py-2 px-4 rounded-lg hover:bg-opacity-90 transition-colors text-sm">
                                    Login to Buy
                                </a>
                            @endguest
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="flex justify-center">
            {{ $products->appends(request()->query())->links() }}
        </div>
    @else
        <!-- No Products Found -->
        <div class="bg-white rounded-lg shadow-md p-12 text-center">
            <svg class="mx-auto h-24 w-24 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.34 0-4.47-.881-6.08-2.33" />
            </svg>
            <h3 class="text-xl font-semibold text-gray-600 mb-2">No Products Found</h3>
            <p class="text-gray-500 mb-4">We couldn't find any products matching your criteria.</p>
            <a href="{{ route('products.index') }}" class="bg-[#2980B9] text-white px-6 py-2 rounded-lg hover:bg-opacity-90 transition-colors">
                View All Products
            </a>
        </div>
    @endif
</div>
@endsection
