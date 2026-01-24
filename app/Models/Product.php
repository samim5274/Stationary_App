<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'sku',

        'category_id',

        'subcategory_id',

        'price',
        'discount',
        'cost_price',

        'stock',
        'min_stock',

        'unit',
        'size',

        'image',

        'availability',
        'status',
        'manufactured_at',
        'expired_at',
        'description',
    ];

    protected $casts = [
        'price'          => 'decimal:2',
        'discount'       => 'decimal:2',
        'cost_price'     => 'decimal:2',
        'manufactured_at'=> 'date',
        'expired_at'     => 'date',
        'availability'   => 'boolean',
        'status'         => 'boolean',
    ];

    protected static function booted()
    {
        static::creating(function ($product) {
            if (empty($product->sku)) {
                $product->sku = 'SKU-' . strtoupper(Str::random(8));
            }
            if (empty($product->slug) && !empty($product->name)) {
                $product->slug = Str::slug($product->name) . '-' . strtolower(Str::random(4));
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(PdrCategory::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(PdrSubCategory::class);
    }

    public function stocks()
    {
        return $this->hasMany(PdrStock::class);
    }
}
