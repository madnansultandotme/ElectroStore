<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InventoryLog extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'product_id',
        'type',
        'quantity_change',
        'stock_before',
        'stock_after',
        'reason',
        'user_id',
        'reference_type',
        'reference_id'
    ];
    
    /**
     * Get the product for this inventory log.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    
    /**
     * Get the user who made this inventory change.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Get the reference model (Order, etc.).
     */
    public function reference()
    {
        return $this->morphTo();
    }
    
    /**
     * Log inventory change.
     */
    public static function logChange($product, $type, $quantityChange, $reason = null, $userId = null, $referenceType = null, $referenceId = null)
    {
        $stockBefore = $product->stock;
        $stockAfter = $stockBefore + $quantityChange;
        
        return self::create([
            'product_id' => $product->id,
            'type' => $type,
            'quantity_change' => $quantityChange,
            'stock_before' => $stockBefore,
            'stock_after' => $stockAfter,
            'reason' => $reason,
            'user_id' => $userId,
            'reference_type' => $referenceType,
            'reference_id' => $referenceId,
        ]);
    }
}
