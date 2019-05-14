<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(CartLine::class);
    }

    public function scopeActive($query)
    {
        return $query->where('delivery_status', 0);
    }

    public function scopeNewestFirst($query)
    {
        return $query->orderByDesc('id');
    }
}
