<?php

namespace App\MercatodoModels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Permission
 * @package App\MercatodoPermission\Models
 */
class Permission extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable =
    [
        'name', 'slug','description',
    ];

    /**
     * Relationship between roles tables and permisions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany('App\MercatodoModels\Role')->withTimesTamps();
    }
}
