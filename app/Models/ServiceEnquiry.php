<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceEnquiry extends Model
{
    //
    protected $table = 'service_enquiry';

    
    public function products_group()
    {
        return $this->belongsTo(ProductsGroup::class, 'enq_pro_group');
    }


    public function products()
    {
        return $this->belongsTo(Products::class, 'product_category');
    }

}
