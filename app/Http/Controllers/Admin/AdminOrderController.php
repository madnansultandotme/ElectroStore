<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\InventoryLog;
use App\Mail\OrderStatusChanged;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class AdminOrderController extends Controller
{
    /**
     * Display a listing of orders.
     */
    public function index(Request $request)
    {
        $query = Order::with(['user', 'orderItems.product'])
            ->orderBy('created_at', 'desc');
            
        // Filter by status if provided
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }
        
        // Search by order ID or customer name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', '%' . $search . '%')
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', '%' . $search . '%')
                               ->orWhere('email', 'like', '%' . $search . '%');
                  });
            });
        }
        
        $orders = $query->paginate(20);
        
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        $order->load(['user', 'orderItems.product.category']);
        
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update order status.
     */
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered'
        ]);
        
        $previousStatus = $order->status;
        $newStatus = $request->status;
        
        // If status is not changing, do nothing
        if ($previousStatus === $newStatus) {
            return back()->with('info', 'Order status is already ' . ucfirst($newStatus));
        }
        
        // Handle inventory adjustments for cancelled orders
        if ($newStatus === 'cancelled' && $previousStatus !== 'cancelled') {
            foreach ($order->orderItems as $item) {
                // Restore stock
                $item->product->increment('stock', $item->quantity);
                
                // Log inventory change
                InventoryLog::logChange(
                    $item->product,
                    'return',
                    $item->quantity,
                    'Order cancelled - stock restored',
                    Auth::id(),
                    'Order',
                    $order->id
                );
            }
        }
        
        // Update order status
        $order->update(['status' => $newStatus]);
        
        // Send email notification
        try {
            Mail::to($order->user->email)->send(
                new OrderStatusChanged($order, $previousStatus, $newStatus)
            );
            $emailSent = true;
        } catch (\Exception $e) {
            $emailSent = false;
            \Log::error('Failed to send order status email: ' . $e->getMessage());
        }
        
        $message = 'Order status updated to ' . ucfirst($newStatus) . '.';
        if ($emailSent) {
            $message .= ' Customer has been notified via email.';
        } else {
            $message .= ' Note: Email notification failed to send.';
        }
        
        return back()->with('success', $message);
    }
    
    /**
     * Update order notes (admin internal notes).
     */
    public function updateNotes(Request $request, Order $order)
    {
        $request->validate([
            'notes' => 'nullable|string|max:1000'
        ]);
        
        $order->update(['notes' => $request->notes]);
        
        return back()->with('success', 'Order notes updated successfully.');
    }

    /**
     * Delete an order (soft delete or archive).
     */
    public function destroy(Order $order)
    {
        if ($order->status === 'delivered') {
            return back()->with('error', 'Cannot delete delivered orders.');
        }
        
        // If order is not cancelled, cancel it first (restore inventory)
        if ($order->status !== 'cancelled') {
            foreach ($order->orderItems as $item) {
                $item->product->increment('stock', $item->quantity);
                
                InventoryLog::logChange(
                    $item->product,
                    'return',
                    $item->quantity,
                    'Order deleted - stock restored',
                    Auth::id(),
                    'Order',
                    $order->id
                );
            }
        }
        
        $order->delete();
        
        return redirect()->route('admin.orders.index')
                        ->with('success', 'Order deleted successfully.');
    }
}
