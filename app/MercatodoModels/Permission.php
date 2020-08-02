<?php

namespace App\MercatodoModels;

use Illuminate\Database\Eloquent\Model;

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
    public function roles(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany('App\MercatodoModels\Role')->withTimesTamps();
    }
}
