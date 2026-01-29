<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomeCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function income()
    {
        return $this->hasMany(Income::class, 'category_id');
    }

    public function subcategories()
    {
        return $this->hasMany(IncomeSubcategory::class, 'category_id');
    }
}
