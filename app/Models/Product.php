<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

use App\Models\Review;
use App\Models\Category;
use App\Models\User;

class Product extends Model
{
    
    
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'image',
        'status',
        'views',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    // Slug otomatis
    protected static function booted(): void
    {
        static::creating(function (Product $product) {

            if (empty($product->slug)) {

                $product->slug = Str::slug($product->name);
            }
        });

        static::updating(function (Product $product) {

            $product->slug = Str::slug($product->name);
        });
    }

    // Seller pemilik produk
    public function seller()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Many-to-Many kategori
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    // Scope produk aktif
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}