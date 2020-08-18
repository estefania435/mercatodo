@extends('plantilla.admin')

@section('title','Administration of details')

@section('breadcrumb')
    <li class="breadcrumb-item active">@yield('title')</li>
@endsection

@section('content')

    <div class="row">

        <span style="display:none;">{{route('admin.detail.index')}}</span>

        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Section of details</h3>

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
                    <table class="table table-head-fixed text-nowrap">
                        <thead>
                        <tr>
                            <th>N</th>
                            <th>Quantity</th>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Subtotal</th>
                            <th colspan="3"></th>
                        </tr>
                        </thead>

                        <tbody>

                        @foreach($details as $detail)
                            <tr>
                                <td>{{$detail->id}}</td>
                                <td>{{$detail->quantity}}</td>
                                <td>{{$detail->products->name}}</td>
                                <td>{{$detail->products->price}}</td>
                                <td>{{$detail->products->price*$detail->quantity}}</td>

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
