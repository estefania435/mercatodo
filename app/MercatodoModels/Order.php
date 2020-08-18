<?php

namespace App\MercatodoModels;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'code','subtotal','iva','total','status','user_id'
    ];

    public function users()
    {
        return $this->belongsTo("App\MercatodoModels\User");
    }

    public function details()
    {
        return $this->hasMany("App\MercatodoModels\Detail");
    }
}
