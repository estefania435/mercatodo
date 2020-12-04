<?php

namespace App\MercatodoModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class Category extends Model
{
    use SoftDeletes;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['name','slug','description'];

    /**
     * Relationship between product tables and categories.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany('App\MercatodoModels\Product');
    }

    public static function cachedCategories()
    {
        return Cache::rememberForever('categories', function () {

            return Category::withTrashed('category')->select('id', 'name', 'slug', 'description', 'deleted_at')
                ->orderBy('name')->get();
        });
    }

    public static function flushCache(): void
    {
        Cache::forget('categories');
    }

    /**
     * Softdelete category.
     *
     * @var string[]
     */
    protected $dates = ['deleted_at'];
}
