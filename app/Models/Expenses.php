<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expenses extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 
        'subcategory_id', 
        'user_id', 
        'title',
        'date', 
        'amount', 
        'remark'
    ];

    public function category()
    {
        return $this->belongsTo(Excategory::class, 'category_id');
    }

    public function subcategory()
    {
        return $this->belongsTo(Exsubcategory::class, 'subcategory_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
