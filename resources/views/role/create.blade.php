@extends('plantilla.admin')

@section('title','Create role')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('role.index') }}">Roles</a></li>
    <li class="breadcrumb-item active">@yield('title')</li>
@endsection

@section('content')

    @include('custom.message')

    <form action="{{ route('role.store') }}" method="POST">
        @csrf

        <div class="container">

            <h3>Required data</h3>

            <div class="form-group">
                <input type="text" class="form-control"
                       id="name"
                       placeholder="Name"
                       name="name"
                       value="{{ old('name') }}"
                >

            </div>

            <div class="form-group">
                <input type="text" class="form-control"
                       id="slug"
                       placeholder="Slug"
                       name="slug"
                       value="{{ old('slug') }}"
                >
            </div>

            <div class="form-group">
                                        <textarea class="form-control" placeholder="Decription" name="decription"
                                                  id="decription"
                                                  rows="3">
                                            {{ old('description') }}
                                        </textarea>
            </div>

            <hr>

            <h3>Full Access</h3>
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="fullaccessyes" name="full-access"
                       class="custom-control-input" value="yes"
                       @if (old('full-access')=="yes")
                       checked
                    @endif

                >
                <label class="custom-control-label" for="fullaccessyes">Yes</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="fullaccessno" name="full-access"
                       class="custom-control-input" value="no"
                       @if (old('full-access')=="no")
                       checked
                       @endif
                       @if (old('full-access')===null)
                       checked
                    @endif

                >
                <label class="custom-control-label" for="fullaccessno">No</label>
            </div>

            <hr>

            <h3>Permission List</h3>

            @foreach($permissions as $permission)


                <div class="custom-control custom-checkbox">
                    <input type="checkbox"
                           class="custom-control-input"
                           id="permission_{{ $permission->id }}"
                           value="{{ $permission->id }}"
                           name="permission[]"

                           @if(is_array(old('permission')) && in_array("$permission->id", old("permission")))
                           checked

                        @endif
                    >
                    <label class="custom-control-label"
                           for="permission_{{ $permission->id }}">
                        {{ $permission->id }}
                        -
                        {{ $permission->name }}
                        <en>({{ $permission->description }})</en>


                    </label>
                </div>

            @endforeach
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
