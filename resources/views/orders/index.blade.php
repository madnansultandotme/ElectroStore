@extends('layouts.app')

@section('title', 'Order History')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-[#2C3E50] mb-4">📦 Order History</h1>
        <p class="text-gray-600">Track your orders and view details</p>
    </div>

    @if($orders->count() > 0)
        <div class="divide-y divide-gray-200">
            @foreach($orders as $order)
                <div class="bg-white rounded-lg shadow-md mb-8 overflow-hidden">
                    <div class="px-6 py-4 flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Order <span class="text-[#2980B9]">#{{ $order->id }}</span></h3>
                            <p class="text-sm text-gray-500">Placed on {{ $order->created_at->format('M d, Y') }}</p>
                            <p class="text-sm">Total: <span class="font-semibold">${{ number_format($order->grandTotal, 2) }}</span></p>
                        </div>

                        <div class="text-right">
                            <span class="inline-block py-1 px-3 rounded-full text-xs font-semibold 
                                           @if($order->status == 'delivered') bg-[#27AE60] text-white 
                                           @elseif($order->status == 'shipped') bg-[#2980B9] text-white 
                                           @elseif($order->status == 'processing') bg-[#F39C12] text-white
                                           @else bg-[#C0392B] text-white @endif">
                                           {{ ucwords($order->status) }}
                            </span>

                            <a href="{{ route('orders.show', $order) }}" class="ml-4 text-[#2980B9] hover:text-[#2980B9]/80 font-medium">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $orders->links() }}
        </div>
    @else
        <div class="bg-white rounded-lg shadow-md p-12 text-center">
            <svg class="mx-auto h-24 w-24 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 3H1m0 0h3m16 10v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6m16 0V9a2 2 0 00-2-2H5a2 2 0 00-2 2v4.01"></path>
            </svg>
            <h3 class="text-xl font-semibold text-gray-600 mb-2">No Orders Yet</h3>
            <p class="text-gray-500 mb-6">Start shopping to create your first order!</p>
            <a href="{{ route('products.index') }}" 
               class="bg-[#2980B9] text-white px-6 py-3 rounded-lg hover:bg-opacity-90 transition-colors font-medium">
                🛒 Start Shopping
            </a>
        </div>
    @endif
</div>
@endsection
