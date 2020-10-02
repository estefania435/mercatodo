<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUpdateRequest;
use App\MercatodoModels\User;
use App\Repositories\User\UserRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Class UserController
 * @package App\Http\Controllers
 */
class UserController extends Controller
{
    protected $usersRepo;

    /**
     * AdminCategoryController constructor.
     * @param UserRepository $usersRepository
     */
    public function __construct(UserRepository $usersRepository)
    {
        $this->usersRepo = $usersRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        $this->authorize('haveaccess', 'user.index');

        $users = $this->usersRepo->getAllUsers();

        return view('user.index', compact('users'));
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return \Illuminate\View\View
     */
    public function show(User $user): View
    {
        $this->authorize('view', [$user, ['user.show','userown.show']]);

        $roles = $this->usersRepo->roleToUser();

        return view('user.view', compact('roles', 'user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @return \Illuminate\View\View
     */
    public function edit(User $user): View
    {
        $this->authorize('update', [$user, ['user.edit','userown.edit']]);

        $roles = $this->usersRepo->roleToUser();

        return view('user.edit', compact('roles', 'user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserUpdateRequest $request, User $user): RedirectResponse
    {
        $this->usersRepo->updateUser($request, $user);

        return redirect()->route('user.index')
            ->with('status_success', 'user update successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user): RedirectResponse
    {
        $this->authorize('haveaccess', 'user.destroy');

        $this->usersRepo->delete($user);

        return redirect()->route('user.index')
            ->with('status_success', 'user successfully disabled');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore(Request $request): RedirectResponse
    {
        $this->usersRepo->restore($request);

        return redirect()->route('user.index')
            ->with('status_success', 'user  enabled');
    }
}
