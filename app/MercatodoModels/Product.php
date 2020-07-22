<?php

namespace App\MercatodoModels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    public function category()
    {
        return $this->belongsTo('App\MercatodoModels\Category');
    }

    public function images()
    {
        return $this->morphMany('App\MercatodoModels\Image','imageable');
    }

    protected $dates = ['deleted_at'];
}
