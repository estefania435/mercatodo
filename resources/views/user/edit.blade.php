@extends('plantilla.admin')

@section('title','Edit user')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('user.index') }}">Users</a></li>
    <li class="breadcrumb-item active">@yield('title')</li>
@endsection

@section('content')

    <form action="{{ route('user.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="container">

            <h3>Required data</h3>

            <div class="form-group">
                <input type="text"
                       class="form-control"
                       id="name"
                       placeholder="Name"
                       name="name"
                       value="{{ old('name',$user->name) }}"
                >
            </div>

            <div class="form-group">
                <input type="text"
                       class="form-control"
                       id="surname"
                       placeholder="Surname"
                       name="surname"
                       value="{{ old('surname',$user->surname) }}"
                >
            </div>
            <div class="form-group">
                <input type="number"
                       class="form-control"
                       id="identification"
                       placeholder="Identification"
                       name="identification"
                       value="{{ old('Identification',$user->identification) }}"
                >
            </div>
            <div class="form-group">
                <input type="text"
                       class="form-control"
                       id="address"
                       placeholder="Address"
                       name="address"
                       value="{{ old('address',$user->address) }}"
                >
            </div>
            <div class="form-group">
                <input type="number"
                       class="form-control"
                       id="phone"
                       placeholder="Phone"
                       name="phone"
                       value="{{ old('Phone',$user->phone) }}"
                >
            </div>

            <div class="form-group">
                <input type="text"
                       class="form-control"
                       id="email"
                       placeholder="email"
                       name="email"
                       value="{{ old('email',$user->email) }}"
                >
            </div>

            <div class="form-group">

                <select class="form-control" name="roles" id="roles">
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}"
                                @isset($user->roles[0]->name)
                                @if($role->name == $user->roles[0]->name)
                                selected
                            @endif
                            @endisset
                        >{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>
            <hr>
            <input class="btn btn-primary" type="submit" value="Save">

        </div>

    </form>

    </div>

@endsection
