<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Excategory extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function subcategories()
    {
        return $this->hasMany(Exsubcategory::class, 'category_id');
    }

    public function expenses()
    {
        return $this->hasMany(Expenses::class, 'category_id');
    }
}
