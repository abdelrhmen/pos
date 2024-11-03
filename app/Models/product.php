<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Stmt\Catch_;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'name_ar',
        'description_ar',
        'name_en',
        'description_en',
        'image',
        'purchase_price',
        'sale_price',
        'stock',
    ];

    protected $appends = ['image_path', 'profit_percent'];


    public function getImagePathAttribute()
    {
        return asset('uploads/product_images/' . $this->image);
    }



    public function getProfitPercentAttribute()
    {
        $profit = $this->sale_price - $this->purchase_price;
        $profit_percent = $profit * 100 / $this->purchase_price;
        return number_format($profit_percent, 2);

    }//end of get profit attribute


    public function catgeory()
    {
        return $this->belongsTo(Category::class);
    }

}
