<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PdrStock extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'ref',
        'date',
        'type',      // IN / OUT / ADJUST
        'qty',
        'remark',
        'created_by',
    ];

    protected $casts = [
        'date' => 'date',
        'qty'  => 'integer',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
