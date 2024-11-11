<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
        'image_url',
        'image',
        'category_id',
        'is_active',
        'is_featured',
        'total_sales'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'total_sales' => 'integer'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            $product->slug = Str::slug($product->name);
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_active', true)
                    ->orderBy('created_at', 'desc');
    }

    public function scopeBestSellers($query)
    {
        return $query->where('is_active', true)
                    ->orderBy('total_sales', 'desc');
    }
}
