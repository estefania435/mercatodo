<?php

namespace App\MercatodoModels;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Role
 * @package App\MercatodoPermission\Models
 */
class Role extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable =
    [
        'name', 'slug','description', 'full-access',
    ];

    /**
     * Relationship between roles tables and users.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('App\MercatodoModels\User')->withTimesTamps();
    }

    /**
     * Relationship between roles tables and permissions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany('App\MercatodoModels\Permission')->withTimesTamps();
    }
}
