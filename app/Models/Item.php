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
}
