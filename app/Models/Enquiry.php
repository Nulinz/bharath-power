<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{
    //
    protected $table = 'enquiry';

    public function products_group()
    {
        return $this->belongsTo(ProductsGroup::class, 'enq_pro_group');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'product_category');
    }

    public function products()
    {
        return $this->belongsTo(Products::class, 'product_category');
    }

}
