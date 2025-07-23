@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Breadcrumb -->
    <nav class="flex mb-8" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('products.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-[#2980B9]">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                    </svg>
                    Products
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="ml-1 text-sm font-medium text-gray-500">{{ $product->category->name }}</span>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="ml-1 text-sm font-medium text-gray-500 truncate">{{ $product->name }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Product Details -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-12">
        <!-- Product Image -->
        <div class="bg-white rounded-lg shadow-md p-8">
            <div class="aspect-square flex items-center justify-center bg-gray-100 rounded-lg">
                @if($product->image)
                    <img src="{{ asset('images/' . $product->image) }}" 
                         alt="{{ $product->name }}" 
                         class="max-h-full max-w-full object-contain rounded-lg">
                @else
                    <div class="text-gray-400 text-center">
                        <svg class="mx-auto h-32 w-32 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                        </svg>
                        <p class="text-lg">No Image Available</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Product Information -->
        <div class="bg-white rounded-lg shadow-md p-8">
            <!-- Category Badge -->
            <div class="mb-4">
                <span class="inline-block bg-[#2980B9] text-white text-sm px-3 py-1 rounded-full">
                    {{ $product->category->name }}
                </span>
            </div>

            <!-- Product Name -->
            <h1 class="text-3xl font-bold text-[#2C3E50] mb-4">{{ $product->name }}</h1>

            <!-- Price -->
            <div class="mb-6">
                <span class="text-4xl font-bold text-[#27AE60]">${{ number_format($product->price, 2) }}</span>
            </div>

            <!-- Stock Status -->
            <div class="mb-6">
                @if($product->stock > 0)
                    <div class="flex items-center text-[#27AE60]">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="font-medium">In Stock ({{ $product->stock }} available)</span>
                    </div>
                @else
                    <div class="flex items-center text-[#C0392B]">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        <span class="font-medium">Out of Stock</span>
                    </div>
                @endif
            </div>

            <!-- Add to Cart Form -->
            @auth
                @if(!auth()->user()->is_admin && $product->stock > 0)
                    <form action="{{ route('cart.store') }}" method="POST" class="mb-6">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="flex items-center space-x-4 mb-4">
                            <label for="quantity" class="text-gray-700 font-medium">Quantity:</label>
                            <select name="quantity" id="quantity" 
                                    class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#2980B9]">
                                @for($i = 1; $i <= min(10, $product->stock); $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <button type="submit" 
                                class="w-full bg-[#27AE60] text-white py-3 px-6 rounded-lg hover:bg-opacity-90 transition-colors font-medium text-lg">
                            🛒 Add to Cart
                        </button>
                    </form>
                @elseif($product->stock <= 0)
                    <button disabled 
                            class="w-full bg-gray-400 text-white py-3 px-6 rounded-lg cursor-not-allowed font-medium text-lg mb-6">
                        Out of Stock
                    </button>
                @endif
            @endauth
            @guest
                <div class="mb-6">
                    <a href="{{ route('login') }}" 
                       class="w-full block text-center bg-[#2980B9] text-white py-3 px-6 rounded-lg hover:bg-opacity-90 transition-colors font-medium text-lg">
                        Login to Purchase
                    </a>
                </div>
            @endguest

            <!-- Product Features -->
            <div class="border-t pt-6">
                <h3 class="text-lg font-semibold text-[#2C3E50] mb-3">Product Features</h3>
                <ul class="space-y-2 text-gray-600">
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-[#27AE60]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Fast and reliable delivery
                    </li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-[#27AE60]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Genuine electronic components
                    </li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-[#27AE60]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Technical support available
                    </li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-[#27AE60]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Cash on Delivery available
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Product Description -->
    <div class="bg-white rounded-lg shadow-md p-8 mb-12">
        <h2 class="text-2xl font-bold text-[#2C3E50] mb-4">Product Description</h2>
        <div class="prose max-w-none text-gray-700 leading-relaxed">
            {{ $product->description }}
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
        <div class="mb-12">
            <h2 class="text-2xl font-bold text-[#2C3E50] mb-6">Related Products</h2>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedProducts as $relatedProduct)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                        <!-- Product Image -->
                        <div class="h-40 bg-gray-200 flex items-center justify-center">
                            @if($relatedProduct->image)
                                <img src="{{ asset('images/' . $relatedProduct->image) }}" 
                                     alt="{{ $relatedProduct->name }}" 
                                     class="max-h-full max-w-full object-contain">
                            @else
                                <div class="text-gray-400 text-center">
                                    <svg class="mx-auto h-12 w-12 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                                    </svg>
                                    <p class="text-xs">No Image</p>
                                </div>
                            @endif
                        </div>

                        <!-- Product Info -->
                        <div class="p-4">
                            <h3 class="font-semibold text-gray-800 mb-2 h-12 flex items-center text-sm">
                                {{ $relatedProduct->name }}
                            </h3>
                            
                            <div class="flex justify-between items-center mb-3">
                                <span class="text-xl font-bold text-[#27AE60]">${{ number_format($relatedProduct->price, 2) }}</span>
                                <span class="text-xs text-gray-500">Stock: {{ $relatedProduct->stock }}</span>
                            </div>

                            <a href="{{ route('products.show', $relatedProduct) }}" 
                               class="block w-full bg-[#2C3E50] text-white text-center py-2 px-4 rounded-lg hover:bg-opacity-90 transition-colors text-sm">
                                View Details
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
