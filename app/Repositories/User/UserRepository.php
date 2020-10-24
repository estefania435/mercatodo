<?php

namespace App\Repositories\User;

use App\MercatodoModels\Role;
use App\MercatodoModels\User;
use App\Repositories\BaseRepository;
use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class UserRepository extends BaseRepository
{
    /**
     * @return User
     */
    public function getModel(): User
    {
        return new User();
    }

    /**
     * function for see all users
     *
     * @return LengthAwarePaginator
     */
    public function getAllUsers(): LengthAwarePaginator
    {
        return $this->getModel()->withTrashed('roles')->orderBy('id', 'Desc')->paginate(10);
    }

    /**
     * function for view role of user
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function roleToUser(): Collection
    {
        $roles = Role::orderBy('name')->get();

        return $roles;
    }

    /**
     * function for update a user
     *
     * @param Request $data
     * @param User $user
     * @return User
     */
    public function updateUser(Request $data, User $user): User
    {
        $user->update($data->all());

        $user->roles()->sync($data->get('roles'));

        return $user;
    }
}
