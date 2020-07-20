@extends('plantilla.admin')

@section('title','Administration of products')

@section('breadcrumb')
    <li class="breadcrumb-item active">@yield('title')</li>
@endsection

@section('content')

    <style type="text/css">
        .table1 {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
            text-align: center;
        }

        .table1 td, .table1 th {
            padding: .75rem;
            vertical-align: center;
            border-top: 1px solid #dee2e6;
        }

    </style>

    <div id="confirmdelete" class="row">

        <span style="display:none;" id="urlbase">{{route('admin.product.index')}}</span>

        @include('custom.modal_delete')
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Section of products</h3>

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
                    <td><a class=" m-2 float-right btn btn-primary" href="{{ route('admin.product.create') }}">Create</a></td>
                    <table class="table1 table-head-fixed text-nowrap">
                        <thead>
                        <tr>

                            <th>Name</th>
                            <th>Image</th>
                            <th>Price</th>

                            <th colspan="3"></th>

                        </tr>
                        </thead>
                        <tbody>


                        @foreach($products as $product)
                            <tr>

                                <td>{{$product->name}}</td>
                                <td>
                                    @if($product->images->count()<=0)
                                        <img style="height: 100px; width: 100px" src="/images/avatar.png" class="rounded-circle">
                                    @else
                                        <img style="height: 100px; width: 100px"  src="{{ $product->images->random()->url }}" class="rounded-circle">
                                    @endif
                                </td>
                                <td>{{$product->slug}}</td>


                                <td><a class="btn btn-default"
                                       href="{{ route('admin.product.show',$product->slug) }}">See</a></td>

                                <td><a class="btn btn-info"
                                       href="{{ route('admin.product.edit',$product->slug) }}">Edit</a></td>

                                <td><a class="btn btn-danger"
                                       href="{{ route('admin.product.index') }}"
                                       v-on:click.prevent="you_want_to_delete({{$product->id}})"
                                    >Destroy</a></td>

                                <td> </td>
                                <td> </td>


                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                    {{ $products->appends($_GET)->links() }}
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>


@endsection
