<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display the shopping cart.
     */
    public function index()
    {
        $cartItems = CartItem::with('product.category')
            ->where('user_id', Auth::id())
            ->get();
        
        $total = $cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });
        
        return view('cart.index', compact('cartItems', 'total'));
    }
    
    /**
     * Add a product to the cart.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);
        
        $product = Product::findOrFail($request->product_id);
        
        // Check if product is active and in stock
        if (!$product->status || $product->stock < $request->quantity) {
            return back()->with('error', 'Product is not available or insufficient stock.');
        }
        
        // Check if item already exists in cart
        $cartItem = CartItem::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->first();
        
        if ($cartItem) {
            // Update quantity if item exists
            $newQuantity = $cartItem->quantity + $request->quantity;
            
            if ($newQuantity > $product->stock) {
                return back()->with('error', 'Not enough stock available.');
            }
            
            $cartItem->update(['quantity' => $newQuantity]);
        } else {
            // Create new cart item
            CartItem::create([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
                'quantity' => $request->quantity
            ]);
        }
        
        return back()->with('success', 'Product added to cart successfully!');
    }
    
    /**
     * Update cart item quantity.
     */
    public function update(Request $request, CartItem $item)
    {
        // Ensure the cart item belongs to the authenticated user
        if ($item->user_id !== Auth::id()) {
            abort(403);
        }
        
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);
        
        if ($request->quantity > $item->product->stock) {
            return back()->with('error', 'Not enough stock available.');
        }
        
        $item->update(['quantity' => $request->quantity]);
        
        return back()->with('success', 'Cart updated successfully!');
    }
    
    /**
     * Remove item from cart.
     */
    public function destroy(CartItem $item)
    {
        // Ensure the cart item belongs to the authenticated user
        if ($item->user_id !== Auth::id()) {
            abort(403);
        }
        
        $item->delete();
        
        return back()->with('success', 'Item removed from cart.');
    }
}
