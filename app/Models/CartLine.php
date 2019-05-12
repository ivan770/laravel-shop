<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartLine extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
