<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MercatodoPermission\Models\Role;
use App\MercatodoPermission\Models\Permission;
use Illuminate\Support\Facades\Gate;

/**
 * Class RoleController
 * @package App\Http\Controllers
 */
class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(): \Illuminate\View\View
    {
        Gate::authorize('haveaccess', 'role.index');

        $roles = Role::orderBy('id', 'Desc')->paginate(2);

        return view('role.index', compact('roles'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(): \Illuminate\View\View
    {
        Gate::authorize('haveaccess', 'role.create');

        $permissions = Permission::get();

        return view('role.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        Gate::authorize('haveaccess', 'role.create');
        $request->validate([
       'name'       => 'required|max:50|unique:roles,name',
       'slug'       => 'required|max:50|unique:roles,slug',
       'full-access'=> 'required|in:yes,no'
    ]);
        $role = Role::create($request->all());

        $role->permissions()->sync($request->get('permission'));

        return redirect()->route('role.index')
            ->with('status_success', 'Role Saved successfully');
    }


    /**
     * Display the specified resource.
     *
     * @param Role $role
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Role $role): \Illuminate\View\View
    {
        $this->authorize('haveaccess', 'role.show');
        $permission_role=[];
        foreach ($role->permissions as $permission) {
            $permission_role[]=$permission->id;
        }

        $permissions = Permission::get();

        return view('role.view', compact('permissions', 'role', 'permission_role'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Role $role
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Role $role): \Illuminate\View\View
    {
        $this->authorize('haveaccess', 'role.edit');

        $permission_role=[];
        foreach ($role->permissions as $permission) {
            $permission_role[]=$permission->id;
        }


        $permissions = Permission::get();

        return view('role.edit', compact('permissions', 'role', 'permission_role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Role $role
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, Role $role): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('haveaccess', 'role.edit');

        $request->validate([
            'name'       => 'required|max:50|unique:roles,name,'.$role->id,
            'slug'       => 'required|max:50|unique:roles,slug,'.$role->id,
            'full-access'=> 'required|in:yes,no'
        ]);
        $role->update($request->all());

        $role->permissions()->sync($request->get('permission'));

        return redirect()->route('role.index')
            ->with('status_success', 'Role update successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Role $role
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Role $role): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('haveaccess', 'role.destroy');

        $role->delete();

        return redirect()->route('role.index')
            ->with('status_success', 'Role successfully removed');
    }
}
