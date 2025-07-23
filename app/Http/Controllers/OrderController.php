<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    /**
     * Display the user's orders.
     */
    public function index()
    {
        $orders = Order::with('orderItems.product')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('orders.index', compact('orders'));
    }
    
    /**
     * Show the specified order.
     */
    public function show(Order $order)
    {
        // Ensure the order belongs to the authenticated user
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }
        
        $order->load('orderItems.product.category');
        
        return view('orders.show', compact('order'));
    }
    
    /**
     * Process checkout and create order.
     */
    public function store(Request $request)
    {
        $request->validate([
            'address' => 'required|string|max:500',
            'phone' => 'required|string|max:20'
        ]);
        
        $cartItems = CartItem::with('product')
            ->where('user_id', Auth::id())
            ->get();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }
        
        // Calculate totals
        $subtotal = $cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });
        
        $shippingFee = 50; // Fixed shipping fee
        $total = $subtotal + $shippingFee;
        
        DB::transaction(function () use ($request, $cartItems, $total, $shippingFee) {
            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'address' => $request->address,
                'phone' => $request->phone,
                'payment_method' => 'COD',
                'total_price' => $total - $shippingFee,
                'shipping_fee' => $shippingFee,
                'status' => 'pending'
            ]);
            
            // Create order items and update stock
            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->product->price
                ]);
                
                // Update product stock
                $cartItem->product->decrement('stock', $cartItem->quantity);
            }
            
            // Clear cart
            CartItem::where('user_id', Auth::id())->delete();
            
            // Send order confirmation email (you can implement this later)
            // Mail::to(Auth::user()->email)->send(new OrderConfirmation($order));
        });
        
        return redirect()->route('orders.index')->with('success', 'Order placed successfully! You will receive a confirmation email shortly.');
    }
}
