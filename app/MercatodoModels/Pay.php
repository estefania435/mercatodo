<?php

namespace App\MercatodoModels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Relations;

class Pay extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'reference','total','status','user_id','order_id'
    ];

    /**
     * Relationship between orders and users
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function orders(): BelongsTo
    {
        return $this->belongsTo("App\MercatodoModels\Order");
    }

    /**
     * scope to search for the order with state zero and belonging to the authenticated user
     *
     * @param $query
     * @return mixed
     */
    public function scopepay($query)
    {
        return $query->where('user_id', Auth::user()->id)->where('status', '0');
    }
}
