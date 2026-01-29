<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomeSubCategory extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'name'];

    public function income()
    {
        return $this->hasMany(Income::class, 'subcategory_id');
    }
    
    public function category()
    {
        return $this->belongsTo(IncomeCategory::class, 'category_id');
    }
}
