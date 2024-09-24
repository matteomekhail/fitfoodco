<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'order_id',
        'street',
        'city',
        'state',
        'zip',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
