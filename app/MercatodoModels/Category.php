<?php

namespace App\MercatodoModels;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable=['name','slug','description'];

    public function products(){
        return $this->hasMany('App\MercatodoModels\Product');
    }
}
