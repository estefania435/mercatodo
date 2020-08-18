<?php

namespace App\MercatodoModels;

use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'quantity','products_id','order_id'
    ];

    /**
     * relationship between order detail and order
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function orders():\Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo("App\MercatodoModels\Order");
    }

    /**
     * Relationship between products and order
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function products(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo("App\MercatodoModels\Product");
    }
}
