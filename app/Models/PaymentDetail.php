<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'user_id',
        'order_id',
        'reg',
        'total',
        'discount',
        'vat',
        'payable',
        'pay',
        'due',
        'payment_method_id',
    ];

    protected $casts = [
        'date'     => 'date',
        'total'    => 'decimal:2',
        'discount' => 'decimal:2',
        'vat'      => 'decimal:2',
        'payable'  => 'decimal:2',
        'pay'      => 'decimal:2',
        'due'      => 'decimal:2',
    ];

    /* ================= Relations ================= */

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id', 'id');
    }
}
