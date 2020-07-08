@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Edit User</div>

                    <div class="card-body">
                        @include('custom.message')


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
                                           id="SurnameUser"
                                           placeholder="Surname"
                                           name="SurnameUser"
                                           value="{{ old('SurnameUser',$user->SurnameUser) }}"

                                    >
                                </div>
                                <div class="form-group">
                                    <input type="number"
                                           class="form-control"
                                           id="UserIdentification"
                                           placeholder="Identification"
                                           name="UserIdentification"
                                           value="{{ old('Identification',$user->UserIdentification) }}"

                                    >
                                </div>
                                <div class="form-group">
                                    <input type="text"
                                           class="form-control"
                                           id="UserAddress"
                                           placeholder="Address"
                                           name="UserAddress"
                                           value="{{ old('Address',$user->UserAddress) }}"

                                    >
                                </div>
                                <div class="form-group">
                                    <input type="number"
                                           class="form-control"
                                           id="UserPhone"
                                           placeholder="Phone"
                                           name="UserPhone"
                                           value="{{ old('Phone',$user->UserPhone) }}"

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
                </div>
            </div>
        </div>
    </div>
@endsection
