<?php

namespace App\MercatodoModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable =
        [
            'name', 'slug', 'category_id','quantity','price',
            'description', 'specifications', 'data_of_interest', 'status'
        ];
    /**
     * Relationship between product tables and categories.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo('App\MercatodoModels\Category');
    }

    /**
     * Relationship between product tables and images.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function images(): MorphMany
    {
        return $this->morphMany('App\MercatodoModels\Image', 'imageable');
    }

    /**
     * Relationship between product tables and details.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function details(): HasMany
    {
        return $this->hasMany('App\MercatodoModels\Detail');
    }

    public function scopeIsInactive($query, $deleted)
    {
        if ($deleted == 'inactive') {
            return $query->where('deleted_at', '!=', null);
        } else {
            return $query->where('deleted_at', '=', null);
        }
    }

    public function scopePrice($query, $price)
    {
        if ($price) {
            return $query->where('price', '>=', "$price");
        }
    }

    public function scopeName($query, $name)
    {
        if ($name) {
            return $query->where('name', 'like', "%$name%");
        }
    }

    public function scopeCategory($query, $category)
    {
        if ($category) {
                 return $query->where('category_id', 'like', "%$category%");
        }
    }

    /**
     * Softdelete category.
     *
     * @var string[]
     */
    protected $dates = ['deleted_at'];
}
