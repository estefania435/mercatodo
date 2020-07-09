<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MercatodoPermission\Models\Role;
use App\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $this->authorize('view', [$user, ['user.show','userown.show']]);
        $roles= Role::orderBy('name')->get();

        return view('user.view', compact('roles', 'user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $this->authorize('update', [$user, ['user.edit','userown.edit']]);

        $roles= Role::orderBy('name')->get();

        return view('user.edit', compact('roles', 'user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
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
        //}
        return redirect()->route('user.index')
            ->with('status_success', 'user update successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $this->authorize('haveaccess', 'user.destroy');

        $user->delete();

        return redirect()->route('user.index')
            ->with('status_success', 'user successfully disabled');
    }

    public function restore(Request $request)
    {
        User::withTrashed()->find($request->id)->restore();

        return redirect()->route('user.index')
            ->with('status_success', 'user  enabled');
    }
}
