<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;




class Category extends Model
{

    protected $fillable = ['name', 'locale', 'category_id'];


    public function products()
    {
        return $this->hasMany(product::class);
    }
}




