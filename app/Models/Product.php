<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Sale; // IMPORTANT: add this

class Product extends Model
{
protected $fillable = [
    'name',
    'description',
    'purchase_price', 
    'price',
    'quantity'
];

   
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}