<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleStoreRequest;
use App\Http\Requests\RoleUpdateRequest;
use App\MercatodoModels\Role;
use App\Repositories\Role\RoleRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

/**
 * Class RoleController
 * @package App\Http\Controllers
 */
class RoleController extends Controller
{
    protected $rolesRepo;

    /**
     * AdminCategoryController constructor.
     * @param RoleRepository $rolesRepository
     */
    public function __construct(RoleRepository $rolesRepository)
    {
        $this->rolesRepo = $rolesRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        Gate::authorize('haveaccess', 'role.index');

        $roles = $this->rolesRepo->getAllRoles();

        return view('role.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create(): View
    {
        Gate::authorize('haveaccess', 'role.create');

        $permissions = $this->rolesRepo->permissionForFormCreate();

        return view('role.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(RoleStoreRequest $request): RedirectResponse
    {
        Gate::authorize('haveaccess', 'role.create');

        $this->rolesRepo->storeRole($request);

        return redirect()->route('role.index')
            ->with('status_success', 'Role Saved successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param Role $role
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @return \Illuminate\View\View
     */
    public function show(Role $role): View
    {
        $this->authorize('haveaccess', 'role.show');

        $permission_role = $this->rolesRepo->showrole($role);

        $permissions = $this->rolesRepo->permissionForFormCreate();

        return view('role.view', compact('permissions', 'role', 'permission_role'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Role $role
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @return \Illuminate\View\View
     */
    public function edit(Role $role): View
    {
        $this->authorize('haveaccess', 'role.edit');

        $permission_role = $this->rolesRepo->showrole($role);

        $permissions = $this->rolesRepo->permissionForFormCreate();

        return view('role.edit', compact('permissions', 'role', 'permission_role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Role $role
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(RoleUpdateRequest $request, Role $role): RedirectResponse
    {
        $this->authorize('haveaccess', 'role.edit');

        $this->rolesRepo->updateRole($request, $role);

        return redirect()->route('role.index')
            ->with('status_success', 'Role update successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Role $role
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Role $role): RedirectResponse
    {
        $this->authorize('haveaccess', 'role.destroy');

        $this->rolesRepo->delete($role);

        return redirect()->route('role.index')
            ->with('status_success', 'Role successfully removed');
    }
}
