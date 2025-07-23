<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'image',
        'category_id',
        'status',
        'min_stock',
        'max_stock',
        'cost_price',
        'sku',
        'barcode',
        'supplier',
        'weight',
        'dimensions',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'cost_price' => 'decimal:2',
            'weight' => 'decimal:2',
            'status' => 'boolean',
            'dimensions' => 'array',
        ];
    }

    /**
     * Get the category that owns the product.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the cart items for the product.
     */
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Get the order items for the product.
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Set the name attribute and generate slug.
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    /**
     * Scope to get active products.
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    /**
     * Scope to get products in stock.
     */
    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }
    
    /**
     * Get the reviews for the product.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    
    /**
     * Get the inventory logs for the product.
     */
    public function inventoryLogs()
    {
        return $this->hasMany(InventoryLog::class);
    }
    
    /**
     * Get average rating.
     */
    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }
    
    /**
     * Get total reviews count.
     */
    public function getTotalReviewsAttribute()
    {
        return $this->reviews()->count();
    }
    
    /**
     * Check if stock is low.
     */
    public function isLowStock()
    {
        return $this->stock <= $this->min_stock;
    }
    
    /**
     * Get profit margin.
     */
    public function getProfitMarginAttribute()
    {
        if (!$this->cost_price || $this->cost_price == 0) {
            return 0;
        }
        return (($this->price - $this->cost_price) / $this->cost_price) * 100;
    }
    
    /**
     * Scope for low stock products.
     */
    public function scopeLowStock($query)
    {
        return $query->whereRaw('stock <= min_stock');
    }
}
