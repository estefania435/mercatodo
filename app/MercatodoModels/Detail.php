<?php

namespace App\MercatodoModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Detail extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'quantity','products_id','order_id',
    ];

    /**
     * relationship between order detail and order
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function orders(): BelongsTo
    {
        return $this->belongsTo('App\MercatodoModels\Order');
    }

    /**
     * Relationship between products and order
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function products(): BelongsTo
    {
        return $this->belongsTo('App\MercatodoModels\Product');
    }
}
