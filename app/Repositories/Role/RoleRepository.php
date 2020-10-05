<?php

namespace App\Repositories\Role;

use App\MercatodoModels\Permission;
use App\MercatodoModels\Role;
use App\Repositories\BaseRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class RoleRepository extends BaseRepository
{
    /**
     * @return Role
     */
    public function getModel(): Role
    {
        return new Role();
    }

    /**
     * function for lis all roles
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAllRoles(): LengthAwarePaginator
    {
        return $this->getModel()->orderBy('id', 'Desc')->paginate(5);
    }

    /**
     * Function for validate permision for form create
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function permissionForFormCreate(): Collection
    {
        return Permission::get();
    }

    /**
     * function for save the role
     *
     * @param object $data
     * @return object
     */
    public function storeRole(object $data): object
    {
        $role = $this->getModel()->create($data->all());

        $role->permissions()->sync($data->get('permission'));

        return $role;
    }

    /**
     * function for show role
     *
     * @param Role $role
     * @return array
     */
    public function showrole(Role $role): array
    {
        $permission_role = [];
        foreach ($role->permissions as $permission) {
            $permission_role[] = $permission->id;
        }

        return $permission_role;
    }

    /**
     * function for update role
     *
     * @param object $data
     * @param Role $role
     * @return Role
     */
    public function updateRole($data, Role $role): Role
    {
        $role->update($data->all());

        $role->permissions()->sync($data->get('permission'));

        return $role;
    }
}
