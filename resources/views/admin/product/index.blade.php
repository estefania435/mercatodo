@extends('plantilla.admin')

@section('title','Administration of products')

@section('breadcrumb')
    <li class="breadcrumb-item active">@yield('title')</li>
@endsection

@section('content')


    <div id="confirmdelete" class="row">

        <span style="display:none;" id="urlbase">{{route('admin.product.index')}}</span>

        @include('custom.modal_delete')
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Section of products</h3>

                    @include('custom.modal_search-product-admin')

                </div>


                <!-- /.card-header -->
                <div class="card-body table-responsive p-0" style="height: 300px;">

                    <td><a class=" m-2 float-right btn btn-primary"
                           href="{{ route('report.products', $request) }}">Report</a></td>

                    @can('haveaccess','admin.product.create')
                    <td><a class=" m-2 float-right btn btn-primary"
                           href="{{ route('admin.product.create') }}">Create product</a></td>
                    @endcan

                   @include('custom.modal_import')

                   @include('custom.modal_export')

                        <table class="table table-head-fixed text-nowrap">                        <thead>
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

                                    <img style="height: 100px; width: 100px" src="{{ $product->images->random()->url }}"
                                         class="rounded-circle">
                                </td>
                                <td>{{$product->price}}</td>

                                @can('haveaccess','admin.product.show')
                                <td><a class="btn btn-default"
                                       href="{{ route('admin.product.show',$product->slug) }}">See</a></td>
                                @endcan

                                @can('haveaccess','admin.product.edit')
                                <td><a class="btn btn-info"
                                       href="{{ route('admin.product.edit',$product->slug) }}">Edit</a></td>
                                @endcan

                                @can('haveaccess','admin.product.destroy')
                                <td>
                                    @if($product->trashed())
                                        <form action=" {{ route('admin.product.restore', ['id'=> $product->id]) }}"
                                              method="POST">
                                            @csrf
                                            <button class="btn btn-success">
                                                Activate
                                            </button>
                                        </form>


                                    @else



                                        <form action="{{ route('admin.product.destroy',$product->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger"
                                                    onclick="return confirm('¿do you want to disable this product?');">
                                                Inactivate
                                            </button>
                                        </form>
                                    @endif

                                </td>
                                @endcan

                                <td></td>
                                <td></td>


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
