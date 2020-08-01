<?php

namespace App\MercatodoModels;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Image
 * @package App\MercatodoModels
 */
class Image extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable =
    [
        'url',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function imageable(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
        return $this->morphTo();
    }
}
