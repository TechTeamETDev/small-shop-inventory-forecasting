<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // This line is EXTREMELY important for saving data!
    protected $fillable = ['name', 'description'];
}