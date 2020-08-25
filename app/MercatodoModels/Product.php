<?php

namespace App\MercatodoModels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Product
 * @package App\MercatodoModels
 */
class Product extends Model
{
    use SoftDeletes;

    /**
     * Relationship between product tables and categories.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\MercatodoModels\Category');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function images(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany('App\MercatodoModels\Image', 'imageable');
    }

    /**
     * Relationship between product tables and details.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function details(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany("App\MercatodoModels\Detail");
    }

    /**
     * Softdelete category.
     *
     * @var string[]
     */
    protected $dates = ['deleted_at'];
}
