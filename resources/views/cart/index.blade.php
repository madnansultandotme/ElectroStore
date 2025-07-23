@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-[#2C3E50] mb-4">🛒 Shopping Cart</h1>
        <p class="text-gray-600">Review your items and proceed to checkout</p>
    </div>

    @if($cartItems->count() > 0)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Cart Items -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-800">Cart Items ({{ $cartItems->count() }})</h2>
                    </div>
                    
                    <div class="divide-y divide-gray-200">
                        @foreach($cartItems as $item)
                            <div class="p-6 flex items-center space-x-4">
                                <!-- Product Image -->
                                <div class="flex-shrink-0 w-20 h-20 bg-gray-100 rounded-lg flex items-center justify-center">
                                    @if($item->product->image)
                                        <img src="{{ asset('images/' . $item->product->image) }}" 
                                             alt="{{ $item->product->name }}" 
                                             class="max-h-full max-w-full object-contain rounded-lg">
                                    @else
                                        <svg class="w-10 h-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                                        </svg>
                                    @endif
                                </div>

                                <!-- Product Info -->
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-lg font-semibold text-gray-800 truncate">
                                        {{ $item->product->name }}
                                    </h3>
                                    <p class="text-sm text-gray-500">{{ $item->product->category->name }}</p>
                                    <p class="text-lg font-bold text-[#27AE60] mt-1">
                                        ${{ number_format($item->product->price, 2) }}
                                    </p>
                                </div>

                                <!-- Quantity Controls -->
                                <div class="flex items-center space-x-2">
                                    <form action="{{ route('cart.update', $item) }}" method="POST" class="flex items-center">
                                        @csrf
                                        @method('PATCH')
                                        <label for="quantity-{{ $item->id }}" class="sr-only">Quantity</label>
                                        <select name="quantity" id="quantity-{{ $item->id }}" 
                                                class="border border-gray-300 rounded-lg px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-[#2980B9]"
                                                onchange="this.form.submit()">
                                            @for($i = 1; $i <= min(10, $item->product->stock + $item->quantity); $i++)
                                                <option value="{{ $i }}" {{ $i == $item->quantity ? 'selected' : '' }}>
                                                    {{ $i }}
                                                </option>
                                            @endfor
                                        </select>
                                    </form>
                                </div>

                                <!-- Item Total -->
                                <div class="text-right">
                                    <p class="text-lg font-bold text-gray-800">
                                        ${{ number_format($item->quantity * $item->product->price, 2) }}
                                    </p>
                                </div>

                                <!-- Remove Button -->
                                <div class="flex-shrink-0">
                                    <form action="{{ route('cart.destroy', $item) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="text-red-600 hover:text-red-800 p-1"
                                                onclick="return confirm('Remove this item from cart?')">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Continue Shopping -->
                <div class="mt-6">
                    <a href="{{ route('products.index') }}" 
                       class="inline-flex items-center text-[#2980B9] hover:text-[#2980B9]/80 font-medium">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Continue Shopping
                    </a>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6 sticky top-8">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Order Summary</h2>
                    
                    <!-- Items Total -->
                    <div class="space-y-3 mb-4">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="font-medium">${{ number_format($total, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Shipping</span>
                            <span class="font-medium">$50.00</span>
                        </div>
                        <div class="border-t pt-3">
                            <div class="flex justify-between">
                                <span class="text-lg font-semibold">Total</span>
                                <span class="text-lg font-bold text-[#27AE60]">${{ number_format($total + 50, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Checkout Form -->
                    @auth
                        @if(!auth()->user()->is_admin)
                        <form action="{{ route('checkout.store') }}" method="POST" class="space-y-4">
                            @csrf
                            
                            <!-- Address -->
                            <div>
                                <label for="address" class="block text-sm font-medium text-gray-700 mb-1">
                                    Delivery Address *
                                </label>
                                <textarea name="address" 
                                          id="address" 
                                          rows="3" 
                                          required
                                          class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#2980B9]"
                                          placeholder="Enter your complete delivery address...">{{ old('address') }}</textarea>
                                @error('address')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Phone -->
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">
                                    Phone Number *
                                </label>
                                <input type="tel" 
                                       name="phone" 
                                       id="phone" 
                                       required
                                       value="{{ old('phone') }}"
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#2980B9]"
                                       placeholder="Enter your phone number">
                                @error('phone')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Payment Method -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Payment Method</label>
                                <div class="flex items-center p-3 border border-gray-300 rounded-lg bg-gray-50">
                                    <svg class="w-5 h-5 text-[#27AE60] mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    <span class="font-medium">Cash on Delivery (COD)</span>
                                </div>
                                <p class="text-sm text-gray-500 mt-1">Pay when you receive your order</p>
                            </div>

                            <!-- Checkout Button -->
                            <button type="submit" 
                                    class="w-full bg-[#27AE60] text-white py-3 px-6 rounded-lg hover:bg-opacity-90 transition-colors font-medium text-lg">
                                Place Order 🚀
                            </button>
                        </form>
                        @endif
                    @endauth

                    <!-- Security Note -->
                    <div class="mt-4 p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-[#27AE60] mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            <span class="text-sm text-gray-600">Secure checkout guaranteed</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Empty Cart -->
        <div class="bg-white rounded-lg shadow-md p-12 text-center">
            <svg class="mx-auto h-24 w-24 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 3H1m0 0h3m16 10v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6m16 0V9a2 2 0 00-2-2H5a2 2 0 00-2 2v4.01"></path>
            </svg>
            <h3 class="text-xl font-semibold text-gray-600 mb-2">Your Cart is Empty</h3>
            <p class="text-gray-500 mb-6">Add some electronic components to get started!</p>
            <a href="{{ route('products.index') }}" 
               class="bg-[#2980B9] text-white px-6 py-3 rounded-lg hover:bg-opacity-90 transition-colors font-medium">
                🛒 Start Shopping
            </a>
        </div>
    @endif
</div>
@endsection
