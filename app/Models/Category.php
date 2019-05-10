<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    public function subcategories()
    {
        return $this->belongsToMany(Subcategory::class);
    }
}
