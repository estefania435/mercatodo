<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait UserTrait
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany('App\MercatodoModels\Role')->withTimesTamps();
    }

    /**
     * Permissions for administration of users
     *
     * @param $permission
     * @return bool
     */
    public function havePermission($permission): bool
    {
        foreach ($this->roles as $role) {
            if ($role['full-access'] == 'yes') {
                return true;
            }

            foreach ($role->permissions as $perm) {
                if ($perm->slug == $permission) {
                    return true;
                }
            }
        }

        return false;
    }
}
