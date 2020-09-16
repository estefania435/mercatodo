<?php

namespace App\MercatodoModels;

use Illuminate\Database\Eloquent\Model;

class Pay extends Model
{
    public function scopeDone($query) {
        return $query->where('status', '0');
    }

    protected $fillable = [
        'reference','total','status','user_id','order_id'
    ];

    public function orders()
    {
        return $this->belongsTo("App\MercatodoModels\Order");
    }
}
