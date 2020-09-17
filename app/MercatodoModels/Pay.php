<?php

namespace App\MercatodoModels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


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

    public function scopepay($query)
    {
        return $query->where('user_id', Auth::user()->id)->where('status', '0');
    }
}
