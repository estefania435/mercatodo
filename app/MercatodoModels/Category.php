<?php

namespace App\MercatodoModels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $fillable=['name','slug','description'];

    public function products(){
        return $this->hasMany('App\MercatodoModels\Product');
    }

    protected $dates = ['deleted_at'];
}
