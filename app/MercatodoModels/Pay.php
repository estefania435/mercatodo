<?php

namespace App\MercatodoModels;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Pay extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'reference','total','status','user_id','order_id',
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
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeinProcess($query): Builder
    {
        return $query->where('user_id', Auth::user()->id)->where('status', 'OPEN');
    }
}
