@extends('layouts.app')

@section('title', 'Articles')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-green-600 to-teal-700 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl font-bold mb-6">Latest Articles</h1>
                <p class="text-xl md:text-2xl text-green-100 max-w-3xl mx-auto">
                    Stay updated with the latest technology trends, product reviews, and industry insights
                </p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <!-- Featured Article -->
        <div class="mb-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-8">Featured Article</h2>
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="md:flex">
                    <div class="md:w-1/2">
                        <div class="h-64 md:h-full bg-gradient-to-r from-blue-400 to-purple-500 flex items-center justify-center">
                            <svg class="w-20 h-20 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="md:w-1/2 p-8">
                        <div class="text-sm text-green-600 font-semibold mb-2">FEATURED • TECHNOLOGY</div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">The Future of Smart Home Technology</h3>
                        <p class="text-gray-600 mb-6 leading-relaxed">
                            Discover how artificial intelligence and IoT devices are revolutionizing the way we interact with our homes. 
                            From voice-controlled assistants to automated security systems, explore the cutting-edge technology that's 
                            making homes smarter and more efficient.
                        </p>
                        <div class="flex items-center justify-between">
                            <div class="text-sm text-gray-500">
                                <span>March 15, 2024</span> • <span>5 min read</span>
                            </div>
                            <button class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition duration-200">
                                Read More
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Articles Grid -->
        <div class="mb-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-8">Recent Articles</h2>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Article 1 -->
                <article class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300">
                    <div class="h-48 bg-gradient-to-r from-blue-500 to-indigo-600 flex items-center justify-center">
                        <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div class="p-6">
                        <div class="text-sm text-blue-600 font-semibold mb-2">MOBILE • REVIEW</div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Top 10 Smartphones of 2024</h3>
                        <p class="text-gray-600 mb-4 text-sm leading-relaxed">
                            Our comprehensive review of this year's flagship smartphones, comparing features, performance, and value for money.
                        </p>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">March 10, 2024</span>
                            <button class="text-blue-600 hover:text-blue-800 font-medium text-sm">Read More →</button>
                        </div>
                    </div>
                </article>

                <!-- Article 2 -->
                <article class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300">
                    <div class="h-48 bg-gradient-to-r from-purple-500 to-pink-600 flex items-center justify-center">
                        <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                        </svg>
                    </div>
                    <div class="p-6">
                        <div class="text-sm text-purple-600 font-semibold mb-2">HARDWARE • GUIDE</div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Building Your First Gaming PC</h3>
                        <p class="text-gray-600 mb-4 text-sm leading-relaxed">
                            A step-by-step guide to assembling a high-performance gaming computer that fits your budget and requirements.
                        </p>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">March 8, 2024</span>
                            <button class="text-purple-600 hover:text-purple-800 font-medium text-sm">Read More →</button>
                        </div>
                    </div>
                </article>

                <!-- Article 3 -->
                <article class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300">
                    <div class="h-48 bg-gradient-to-r from-orange-500 to-red-600 flex items-center justify-center">
                        <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <div class="p-6">
                        <div class="text-sm text-orange-600 font-semibold mb-2">ENERGY • TIPS</div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Energy-Efficient Electronics</h3>
                        <p class="text-gray-600 mb-4 text-sm leading-relaxed">
                            Learn how to reduce your carbon footprint while enjoying the latest technology with energy-efficient devices.
                        </p>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">March 5, 2024</span>
                            <button class="text-orange-600 hover:text-orange-800 font-medium text-sm">Read More →</button>
                        </div>
                    </div>
                </article>

                <!-- Article 4 -->
                <article class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300">
                    <div class="h-48 bg-gradient-to-r from-teal-500 to-cyan-600 flex items-center justify-center">
                        <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                        </svg>
                    </div>
                    <div class="p-6">
                        <div class="text-sm text-teal-600 font-semibold mb-2">SECURITY • GUIDE</div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Cybersecurity Best Practices</h3>
                        <p class="text-gray-600 mb-4 text-sm leading-relaxed">
                            Protect your digital life with essential cybersecurity tips and recommended security tools for 2024.
                        </p>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">March 3, 2024</span>
                            <button class="text-teal-600 hover:text-teal-800 font-medium text-sm">Read More →</button>
                        </div>
                    </div>
                </article>

                <!-- Article 5 -->
                <article class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300">
                    <div class="h-48 bg-gradient-to-r from-yellow-500 to-orange-500 flex items-center justify-center">
                        <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                        </svg>
                    </div>
                    <div class="p-6">
                        <div class="text-sm text-yellow-600 font-semibold mb-2">INNOVATION • NEWS</div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">AI in Consumer Electronics</h3>
                        <p class="text-gray-600 mb-4 text-sm leading-relaxed">
                            Explore how artificial intelligence is being integrated into everyday electronics and what it means for consumers.
                        </p>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">March 1, 2024</span>
                            <button class="text-yellow-600 hover:text-yellow-700 font-medium text-sm">Read More →</button>
                        </div>
                    </div>
                </article>

                <!-- Article 6 -->
                <article class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300">
                    <div class="h-48 bg-gradient-to-r from-indigo-500 to-purple-600 flex items-center justify-center">
                        <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2m-9 4h10m-5-3v10m4-7h.01M8 14h.01"></path>
                        </svg>
                    </div>
                    <div class="p-6">
                        <div class="text-sm text-indigo-600 font-semibold mb-2">ACCESSORIES • REVIEW</div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Must-Have Tech Accessories</h3>
                        <p class="text-gray-600 mb-4 text-sm leading-relaxed">
                            Discover essential accessories that will enhance your tech experience and boost your productivity.
                        </p>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">February 28, 2024</span>
                            <button class="text-indigo-600 hover:text-indigo-800 font-medium text-sm">Read More →</button>
                        </div>
                    </div>
                </article>
            </div>
        </div>

        <!-- Newsletter Signup -->
        <div class="bg-gradient-to-r from-blue-600 to-purple-700 rounded-lg shadow-lg text-white p-8 text-center">
            <h2 class="text-2xl font-bold mb-4">Stay Updated</h2>
            <p class="text-blue-100 mb-6 max-w-2xl mx-auto">
                Subscribe to our newsletter to receive the latest articles, product reviews, and technology insights directly to your inbox.
            </p>
            <div class="max-w-md mx-auto flex">
                <input type="email" placeholder="Enter your email address" 
                       class="flex-1 px-4 py-3 rounded-l-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-400">
                <button class="bg-white text-blue-600 px-6 py-3 rounded-r-lg font-semibold hover:bg-gray-100 transition duration-200">
                    Subscribe
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
