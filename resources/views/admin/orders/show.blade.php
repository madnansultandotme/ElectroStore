@extends('layouts.app')

@section('title', 'Order Details')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.orders.index') }}" class="text-blue-600 hover:underline">&larr; Back to Orders</a>
    </div>
    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <h1 class="text-2xl font-bold mb-2">Order #{{ $order->id }}</h1>
        <div class="mb-2">
            <span class="font-medium">Status:</span>
            <span class="inline-block px-2 py-1 rounded text-xs font-semibold
                @if($order->status == 'pending') bg-yellow-100 text-yellow-800
                @elseif($order->status == 'confirmed') bg-blue-100 text-blue-800
                @elseif($order->status == 'shipped') bg-indigo-100 text-indigo-800
                @elseif($order->status == 'delivered') bg-green-100 text-green-800
                @elseif($order->status == 'cancelled') bg-red-100 text-red-800
                @endif">
                {{ ucfirst($order->status) }}
            </span>
        </div>
        <div class="mb-2"><span class="font-medium">Order Date:</span> {{ $order->created_at->format('Y-m-d H:i') }}</div>
        <div class="mb-2"><span class="font-medium">Total:</span> ${{ number_format($order->total_price, 2) }}</div>
    </div>
    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <h2 class="text-lg font-semibold mb-4">Customer Information</h2>
        <div class="mb-2"><span class="font-medium">Name:</span> {{ $order->user->name ?? '-' }}</div>
        <div class="mb-2"><span class="font-medium">Email:</span> {{ $order->user->email ?? '-' }}</div>
        <div class="mb-2"><span class="font-medium">Address:</span> {{ $order->address ?? '-' }}</div>
        <div class="mb-2"><span class="font-medium">Contact:</span> {{ $order->contact_number ?? '-' }}</div>
    </div>
    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <h2 class="text-lg font-semibold mb-4">Ordered Products</h2>
        <table class="min-w-full divide-y divide-gray-200 mb-4">
            <thead>
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($order->orderItems as $item)
                    <tr>
                        <td class="px-4 py-2">{{ $item->product->name ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $item->product->category->name ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $item->quantity }}</td>
                        <td class="px-4 py-2">${{ number_format($item->price, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <h2 class="text-lg font-semibold mb-4">Update Status</h2>
        <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="flex items-center space-x-4 mb-4">
            @csrf
            @method('PUT')
            <select name="status" class="border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Update</button>
        </form>
        <form action="{{ route('admin.orders.notes', $order) }}" method="POST">
            @csrf
            @method('PATCH')
            <div class="mb-2">
                <label for="notes" class="block text-gray-700 font-medium mb-2">Admin Notes</label>
                <textarea name="notes" id="notes" rows="3" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('notes', $order->notes) }}</textarea>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Save Notes</button>
            </div>
        </form>
    </div>
</div>
@endsection 