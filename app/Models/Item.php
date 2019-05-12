<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $guarded = [];

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function cartlines()
    {
        return $this->belongsToMany(CartLine::class);
    }

    public function wishes()
    {
        return $this->belongsToMany(User::class, 'cart_items');
    }
}
