<?php

namespace App\MercatodoModels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class Order extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'code','subtotal','iva','total','status','user_id',
    ];

    /**
     * Relationship between orders and users
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function users(): BelongsTo
    {
        return $this->belongsTo("App\MercatodoModels\User");
    }

    /**
     * Relationship between orders and details
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function details(): HasMany
    {
        return $this->hasMany("App\MercatodoModels\Detail");
    }

    /**
     * scope to search for the order with state zero and belonging to the authenticated user
     *
     * @param $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeorder($query): Builder
    {
        return $query->where('user_id', Auth::user()->id)->where('status', 'OPEN');
    }

    /**
     * scope to search for the order with state zero and belonging to the authenticated user
     *
     * @param $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDone($query): Builder
    {
        return $query->where('orders.user_id', '=', Auth::user()->id)
            ->where('orders.status', '=', 'OPEN');
    }
}
