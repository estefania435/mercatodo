@extends('plantilla.admin')

@section('title','Administration of categories')

@section('breadcrumb')
    <li class="breadcrumb-item active">@yield('title')</li>
@endsection

@section('content')


    <div id="confirmdelete" class="row">

        <span style="display:none;" id="urlbase">{{route('admin.category.index')}}</span>

        @include('custom.modal_delete')
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Section of categories</h3>

                    <div class="card-tools">
                        <form>

                        <div class="input-group input-group-sm" style="width: 150px;">
                            <input type="text" name="name" class="form-control float-right"
                                   placeholder="Search"
                                    value="{{ request()->get('name') }}"
                            >

                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                        </form>

                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0" style="height: 300px;">
                    @can('haveaccess','admin.category.create')
                    <td><a class=" m-2 float-right btn btn-primary" href="{{ route('admin.category.create') }}">Create</a></td>
                    @endcan
                        <table class="table table-head-fixed text-nowrap">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Description</th>
                            <th colspan="3"></th>

                        </tr>
                        </thead>
                        <tbody>


                            @foreach($categories as $category)
                        <tr>
                            <td>{{$category->id}}</td>
                            <td>{{$category->name}}</td>
                            <td>{{$category->slug}}</td>
                            <td>{{$category->description}}</td>

                            @can('haveaccess','admin.category.index')
                            <td><a class="btn btn-default"
                                   href="{{ route('admin.category.show',$category->slug) }}">See</a></td>
                            @endcan

                            @can('haveaccess','admin.category.edit')
                            <td><a class="btn btn-info"
                                   href="{{ route('admin.category.edit',$category->slug) }}">Edit</a></td>
                            @endcan

                            @can('haveaccess','admin.category.destroy')
                            <td>
                                @if($category->trashed())
                                    <form action=" {{ route('admin.category.restore', ['id'=> $category->id]) }}"
                                          method="POST">
                                        @csrf
                                        <button class="btn btn-success">
                                            Activate
                                        </button>
                                    </form>


                                @else



                                    <form action="{{ route('admin.category.destroy',$category->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger"
                                                onclick="return confirm('¿do you want to disable this category?');">
                                            Inactivate
                                        </button>
                                    </form>
                                @endif

                            </td>
                            @endcan

                            <td> </td>
                            <td> </td>


                        </tr>
                            @endforeach

                        </tbody>
                    </table>

                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>


@endsection
