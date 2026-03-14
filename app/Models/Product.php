<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // This tells Laravel these fields are safe to save from your form
    protected $fillable = [
        'name',
        'category_id',
        'price',
        'quantity',
        'description'
    ];

    // This defines the relationship so you can see the category name in your list
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}