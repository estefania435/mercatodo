@extends('plantilla.admin')

@section('title','Administration of reports')

@section('breadcrumb')
    <li class="breadcrumb-item active">@yield('title')</li>
@endsection

@section('content')
    <span style="display:none;" id="urlbase">{{route('admin.report.index')}}</span>

    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Section of reports</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0" style="height: 300px;">

                @include('custom.modal_search-sales')


                <td><a class=" m-2 float-right btn btn-primary" href="{{ route('export.reportProducts') }}">Generate Report</a></td>

                <div class="card-body table-responsive p-0" style="height: 300px;">

                    <table class="table table-head-fixed text-nowrap">
                        <thead>
                        <tr>

                            <th>Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Quantity sold</th>
                            <th>Total</th>
                            <th>Date</th>
                            <th colspan="3"></th>

                        </tr>
                        </thead>
                        <tbody>

                        @foreach($sales as $sale)

                            @foreach($sale->details as $i)

                            <tr>
                                <td>{{$i->products->name}}</td>
                                <td>{{$i->products->category->name}}</td>
                                <td>{{$i->unit_price}}</td>
                                <td>{{$i->quantity}}</td>
                                <td>{{$sale->total}}</td>
                                <td>{{$sale->updated_at}}</td>
                            </tr>
                            @endforeach
                        @endforeach
                        </tbody>
                    </table>

@endsection
