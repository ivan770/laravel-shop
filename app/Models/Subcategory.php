<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
