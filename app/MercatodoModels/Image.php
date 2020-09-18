<?php

namespace App\MercatodoModels;

use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\MorphTo;

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
     * relationship between order detail and order
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }
}
