@extends('plantilla.admin')

@section('title','Show user')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('user.index') }}">Users</a></li>
    <li class="breadcrumb-item active">@yield('title')</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header"></div>

        <div class="card-body">
            @include('custom.message')


            <form action="{{ route('user.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="container">

                    <div class="form-group">
                        <input type="text"
                               class="form-control"
                               id="name"
                               placeholder="Name"
                               name="name"
                               value="{{ old('name',$user->name) }}"
                               disabled
                        >
                    </div>

                    <div class="form-group">
                        <input type="text"
                               class="form-control"
                               id="surname"
                               placeholder="Surname"
                               name="surname"
                               value="{{ old('Surname',$user->surname) }}"
                               disabled
                        >
                    </div>
                    <div class="form-group">
                        <input type="number"
                               class="form-control"
                               id="identification"
                               placeholder="Identification"
                               name="identification"
                               value="{{ old('Identification',$user->identification) }}"
                               disabled
                        >
                    </div>
                    <div class="form-group">
                        <input type="text"
                               class="form-control"
                               id="address"
                               placeholder="Address"
                               name="address"
                               value="{{ old('Address',$user->address) }}"
                               disabled
                        >
                    </div>
                    <div class="form-group">
                        <input type="number"
                               class="form-control"
                               id="phone"
                               placeholder="Phone"
                               name="phone"
                               value="{{ old('Phone',$user->phone) }}"
                               disabled
                        >
                    </div>


                    <div class="form-group">
                        <input type="text"
                               class="form-control"
                               id="email"
                               placeholder="email"
                               name="email"
                               value="{{ old('email',$user->email) }}"
                               disabled
                        >
                    </div>

                    <div class="form-group">
                        <select disabled class="form-control" name="roles" id="roles">
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

                    <a class="btn btn-success" href="{{route('user.edit',$user->id)}}">Edit</a>
                    <a class="btn btn-danger" href="{{route('user.index')}}">Back</a>


                </div>


            </form>


        </div>
    </div>
    </div>
    </div>
    </div>
@endsection
