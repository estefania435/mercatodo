@extends('plantilla.admin')

@section('title','Administration of categories')

@section('content')


    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Section of categories</h3>

                    <div class="card-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0" style="height: 300px;">
                    <td><a class=" m-2 float-right btn btn-primary" href="{{ route('admin.category.create') }}">Create</a></td>
                    <table class="table table-head-fixed text-nowrap">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Description</th>
                            <th>Created at</th>
                            <th>Updated at</th>
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
                            <td>{{$category->created_at}}</td>
                            <td>{{$category->updated_at}}</td>

                            <td><a class="btn btn-default"
                                   href="{{ route('admin.category.show',$category->slug) }}">See</a></td>

                            <td><a class="btn btn-info"
                                   href="{{ route('admin.category.edit',$category->slug) }}">Edit</a></td>

                            <td><a class="btn btn-danger"
                                   href="{{ route('admin.category.index',$category->slug) }}">destroy</a></td>

                            <td> </td>
                            <td> </td>


                        </tr>
                            @endforeach

                        </tbody>
                    </table>
                    {{ $categories->links() }}
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>


@endsection