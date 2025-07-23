<x-mail::message>
# Order Status Update

Hi {{ $customerName }},

We wanted to let you know that your order status has been updated.

**Order Details:**
- Order Number: #{{ $order->id }}
- Order Date: {{ $order->created_at->format('M d, Y') }}
- Previous Status: {{ ucfirst($previousStatus) }}
- **New Status: {{ ucfirst($newStatus) }}**
- Total Amount: ${{ number_format($order->total_price + $order->shipping_fee, 2) }}

@if($newStatus === 'confirmed')
🎉 Great news! Your order has been confirmed and is being prepared for shipment.
@elseif($newStatus === 'shipped')
📦 Your order is on its way! You should receive it within 3-5 business days.
@elseif($newStatus === 'delivered')
✅ Your order has been delivered! We hope you enjoy your purchase.
@elseif($newStatus === 'cancelled')
❌ Your order has been cancelled. If you have any questions, please contact our support team.
@endif

**Order Items:**
@foreach($order->orderItems as $item)
- {{ $item->product->name }} (Qty: {{ $item->quantity }}) - ${{ number_format($item->price * $item->quantity, 2) }}
@endforeach

**Shipping Address:**
{{ $order->address }}

<x-mail::button :url="$trackingUrl">
View Order Details
</x-mail::button>

@if($newStatus !== 'delivered' && $newStatus !== 'cancelled')
If you have any questions about your order, please don't hesitate to contact our customer support team.
@endif

Thank you for shopping with us!

Best regards,<br>
{{ config('app.name') }} Team
</x-mail::message>
