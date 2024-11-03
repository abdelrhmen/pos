<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


// class CategoryTranslation extends Model
// {
//     public $timestamps = false;

//     protected $fillable = ['category_id', 'name', 'locale'];
// }

class ProductTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['name', 'description', 'locale'];
}


