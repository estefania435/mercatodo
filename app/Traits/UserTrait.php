<?php

namespace App\Traits;

trait UserTrait
{
    /**
     * @return mixed
     */
    public function roles()
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
