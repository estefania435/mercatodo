<?php

namespace App\MercatodoModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class Order extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'code','subtotal','iva','total','status','user_id',
    ];

    /**
     * Relationship between orders and users
     *
     * @return BelongsTo
     */
    public function users(): BelongsTo
    {
        return $this->belongsTo('App\MercatodoModels\User');
    }

    /**
     * Relationship between orders and details
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function details(): HasMany
    {
        return $this->hasMany('App\MercatodoModels\Detail');
    }

    /**
     * scope to search for the order with state zero and belonging to the authenticated user
     *
     * @param $query
     * @return Builder
     */
    public function scopeOpen($query): Builder
    {
        return $query->where('orders.user_id', '=', Auth::user()->id)
            ->where('orders.status', '=', 'OPEN');
    }

    /**
     * scope to search for the order with state pending
     *
     * @param $query
     * @return Builder
     */
    public function scopePendig($query): Builder
    {
        return $query->where('orders.status', '=', 'PENDING');
    }

    /**
     * scope to search for the order with state rejected
     *
     * @param $query
     * @return Builder
     */
    public function scopeRejected($query): Builder
    {
        return $query->Orwhere('orders.status', '=', 'REJECTED');
    }

    /**
     * scope to search for the status
     *
     * @param $query
     * @return Builder
     */
    public function scopeStatusOrder($query, $status): Builder
    {
        if ($status) {
            return $query->where('status', 'like', "%$status%");
        }
    }

    /**
     * scope to search for the date
     *
     * @param $query
     * @return Builder
     */
    public function scopeDateOrder($query, $date): Builder
    {
        if ($date) {
            return $query->where('updated_at', 'like', "%$date%");
        }
    }
}
