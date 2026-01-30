<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'bank_name',
        'branch_name',
        'account_name',
        'account_number',
        'routing_number',
        'remarks',
    ];

    public function transection()
    {
        return $this->hasMany(BankTransectionDetail::class, 'bank_id');
    }
}
