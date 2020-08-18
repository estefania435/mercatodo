<?php

namespace App\MercatodoModels;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    /**
     * @var string[]
     */
    public $fillable = array
    (
        'id','name','price','quantity'
    );
}
