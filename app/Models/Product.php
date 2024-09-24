<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     * */
    protected $fillable = [
        'name',
        'description',
        'price',
        'quantity_in_stock',
        'calories',
        'protein',
        'fats',
        'carbs',
        'active',
        'image'
    ];

    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class);
    }

    /**
     * The attributes that should be cast.
     *
     */
    protected $casts = [
        'active' => 'boolean',
        'price' => 'decimal:2'
    ];
}
