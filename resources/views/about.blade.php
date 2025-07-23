@extends('layouts.app')

@section('title', 'About Us')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-blue-600 to-purple-700 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl font-bold mb-6">About Our Store</h1>
                <p class="text-xl md:text-2xl text-blue-100 max-w-3xl mx-auto">
                    Your trusted partner for premium electronics and innovative technology solutions
                </p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid md:grid-cols-2 gap-12 items-center mb-16">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Our Story</h2>
                <p class="text-gray-600 mb-4 leading-relaxed">
                    Founded with a passion for technology and innovation, our Electronic Store has been serving customers 
                    with the latest and greatest in consumer electronics for over a decade. We believe that technology 
                    should enhance your life, not complicate it.
                </p>
                <p class="text-gray-600 mb-4 leading-relaxed">
                    From smartphones and laptops to smart home devices and gaming equipment, we carefully curate our 
                    inventory to bring you only the highest quality products from trusted brands.
                </p>
                <p class="text-gray-600 leading-relaxed">
                    Our commitment goes beyond just selling products – we're here to help you find the perfect 
                    technology solutions that fit your lifestyle and budget.
                </p>
            </div>
            <div class="bg-white rounded-lg shadow-lg p-8">
                <div class="grid grid-cols-2 gap-6 text-center">
                    <div>
                        <div class="text-3xl font-bold text-blue-600 mb-2">10+</div>
                        <div class="text-gray-600">Years Experience</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-blue-600 mb-2">50K+</div>
                        <div class="text-gray-600">Happy Customers</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-blue-600 mb-2">1000+</div>
                        <div class="text-gray-600">Products</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-blue-600 mb-2">24/7</div>
                        <div class="text-gray-600">Support</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Values Section -->
        <div class="mb-16">
            <h2 class="text-3xl font-bold text-gray-900 text-center mb-12">Our Values</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Quality Assurance</h3>
                    <p class="text-gray-600">Every product undergoes rigorous testing to ensure it meets our high standards.</p>
                </div>
                <div class="text-center">
                    <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Fast Delivery</h3>
                    <p class="text-gray-600">Quick and secure shipping to get your products to you as soon as possible.</p>
                </div>
                <div class="text-center">
                    <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M12 2.5a9.5 9.5 0 109.5 9.5A9.5 9.5 0 0012 2.5z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Expert Support</h3>
                    <p class="text-gray-600">Our knowledgeable team is always ready to help you make the right choice.</p>
                </div>
            </div>
        </div>

        <!-- Team Section -->
        <div class="bg-white rounded-lg shadow-lg p-8">
            <h2 class="text-3xl font-bold text-gray-900 text-center mb-8">Why Choose Us?</h2>
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="text-center p-4">
                    <div class="text-blue-600 mb-2">
                        <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h4 class="font-semibold">Best Prices</h4>
                    <p class="text-sm text-gray-600">Competitive pricing on all products</p>
                </div>
                <div class="text-center p-4">
                    <div class="text-blue-600 mb-2">
                        <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <h4 class="font-semibold">Warranty</h4>
                    <p class="text-sm text-gray-600">Full warranty coverage on all items</p>
                </div>
                <div class="text-center p-4">
                    <div class="text-blue-600 mb-2">
                        <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                    </div>
                    <h4 class="font-semibold">24/7 Support</h4>
                    <p class="text-sm text-gray-600">Round-the-clock customer service</p>
                </div>
                <div class="text-center p-4">
                    <div class="text-blue-600 mb-2">
                        <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                        </svg>
                    </div>
                    <h4 class="font-semibold">Free Shipping</h4>
                    <p class="text-sm text-gray-600">Free delivery on orders over $100</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
