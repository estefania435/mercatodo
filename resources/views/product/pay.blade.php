@extends('layouts.master')

@section('content')
    <div class="container text-center">

        <div class="page">
            <div class="table-responsive">
                <div class="container text-center">
                    <div class="page-header">
                        <h1><i class="fa fa-shopping-cart"> </i>Confirmación datos de envío</h1>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-bordered">
                                <tr>
                                    <th>Name</th>
                                    <th>Surname</th>
                                    <th>Address</th>
                                    <th>Contact</th>
                                </tr>

                                <tr>
                                    <td>{{ $order->name_receive }}</td>
                                    <td>{{ $order->surname}}</td>
                                    <td>{{ $order->address }}</td>
                                    <td>{{ $order->phone }}</td>
                                </tr>

                            </table>
                            <p>
                                <a href="{{ route('order-detail') }}" class="btn btn-primary">
                                    <i class="fa fa-chevron-circle-left"></i> Regresar
                                </a>
                                <a href="{{ route('pay.pay') }}" class="btn btn-primary">pagar</a>
                            </p>

                        </div>
                    </div>
                </div>
            </div>
@stop
