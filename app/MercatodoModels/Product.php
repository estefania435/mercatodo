<?php

namespace App\MercatodoModels;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function category()
    {
        return $this->belongsTo('App\MercatodoModels\Category');
    }
}
