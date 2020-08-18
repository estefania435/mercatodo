@extends('plantilla.admin')

@section('title', 'Show order')

@section('content')

    <section class="content">
        <div class="container-fluid">

            <div class="card card-danger">
                <div class="card-header">
                    <h3 class="card-title">Administration</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">

                                <label>Status</label>
                                <select disabled name="status" class="form-control select2"
                                        style="width: 100%;">
                                    @foreach($statusorders as $status )

                                        @if ($status == $order->status)
                                            <option value="{{ $status }}"
                                                    selected="selected">{{ $status }}</option>
                                        @else
                                            <option value="{{ $status }}">{{ $status }}</option>
                                        @endif
                                    @endforeach
                                </select>

                            </div>

                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">

                                <a class="btn btn-danger" href="{{ route('cancel','admin.order.index') }}">cancel</a>

                                <a class="btn btn-outline-success "
                                   href="{{ route('admin.order.edit',$order->id) }}">Edit</a>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

@endsection
