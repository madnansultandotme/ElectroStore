<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'product_id',
        'rating',
        'comment',
        'verified_purchase'
    ];
    
    protected function casts(): array
    {
        return [
            'verified_purchase' => 'boolean',
            'rating' => 'integer',
        ];
    }
    
    /**
     * Get the user who wrote the review.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Get the product being reviewed.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    
    /**
     * Get star rating as text.
     */
    public function getStarRatingAttribute()
    {
        return str_repeat('⭐', $this->rating) . str_repeat('☆', 5 - $this->rating);
    }
}
