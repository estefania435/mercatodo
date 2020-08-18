@extends('plantilla.admin')

@section('title', 'Edit order')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('admin.order.index')}}">orders</a></li>
    <li class="breadcrumb-item active">@yield('title')</li>
@endsection

@section('content')

    <div id="apiorder">

        <form action="{{ route('admin.order.update',$order->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Main content -->
            <section class="content">
                <div class="container-fluid">

                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">order dates</h3>
                        </div>
                    </div>

                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="checkbox" class="custom-control-input" id="status" name="status"

                                       @if($order->status=='no entregado')
                                       checked
                                    @endif
                                >
                                <label class="custom-control-label" for="status">Entregar</label>

                            </div>
                            <!-- /.form-group -->

                        </div>
                        <!-- /.col -->

                    </div>
                    <!-- /.row -->

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">

                                <a class="btn btn-danger"
                                   href="{{ route('cancel','admin.order.index') }}">cancel</a>
                                <input
                                    :disabled="disable_button==1"

                                    type="submit" value="Save" class="btn btn-primary">

                            </div>

                        </div>

                    </div>

                </div>

    </div>
    </section>
    </form>

    </div>

@endsection
