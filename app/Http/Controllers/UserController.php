<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MercatodoModels\Role;
use App\MercatodoModels\User;

/**
 * Class UserController
 * @package App\Http\Controllers
 */
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(): \Illuminate\View\View
    {
        $this->authorize('haveaccess', 'user.index');

        $users = User::withTrashed('roles')->orderBy('id', 'Desc')->paginate(10);

        return view('user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(User $user): \Illuminate\View\View
    {
        $this->authorize('view', [$user, ['user.show','userown.show']]);
        $roles= Role::orderBy('name')->get();

        return view('user.view', compact('roles', 'user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(User $user): \Illuminate\View\View
    {
        $this->authorize('update', [$user, ['user.edit','userown.edit']]);

        $roles= Role::orderBy('name')->get();

        return view('user.edit', compact('roles', 'user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'name'           => 'required|max:50|unique:users,name,'.$user->id,
            'surname'        => 'required|max:50,'.$user->id,
            'identification' => 'required|max:50|unique:users,identification,'.$user->id,
            'address'        => 'required|max:50,'.$user->id,
            'phone'          => 'required|max:50,'.$user->id,
            'email'          => 'required|max:50|unique:users,email,'.$user->id,
        ]);

        $user->update($request->all());

        $user->roles()->sync($request->get('roles'));

        return redirect()->route('user.index')
            ->with('status_success', 'user update successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(User $user): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('haveaccess', 'user.destroy');

        $user->delete();

        return redirect()->route('user.index')
            ->with('status_success', 'user successfully disabled');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore(Request $request): \Illuminate\Http\RedirectResponse
    {
        User::withTrashed()->find($request->id)->restore();

        return redirect()->route('user.index')
            ->with('status_success', 'user  enabled');
    }
}
