<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'user_id',
        'reg',
        'total',
        'status',
        'customerName',
        'customerPhone',
    ];

    protected $casts = [
        'date'  => 'date',
        'total' => 'decimal:2',
        'status'=> 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function payment()
    {
        return $this->hasMany(PaymentDetail::class, 'order_id', 'id');
    }

}
