@extends('layouts.master')

@section('content')
    <div class="container text-center">
        <div class="page-header">
            <h1><i class="fas fa-file-invoice-dollar"></i> Historial de pagos</h1>

            <div class="table-responsive">

                <table class="table table-striped table-hover table-bordered">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Payment Method</th>
                        <th>Name</th>
                        <th>Surname</th>
                        <th>Total</th>
                        <th> </th>

                    </tr>
                    </thead>
                    <tbody>
                @foreach($Payments as $pay)
                    <tr>
                    <th>{{ $pay->created_at }}</th>
                    <th>{{ $pay->status }}</th>
                    <th>{{ $pay->payment_method }}</th>
                    <th>{{ $pay->name }}</th>
                    <th>{{ $pay->surname }}</th>
                    <th>{{ $pay->order_total }}</th>
                        @if($pay->status == 'REJECTED')
                        <td>
                            <a href="{{ route('pay.retryPayment', $pay->reference) }}" class="btn btn-info">
                                Reintentar pago
                            </a>
                        </td>
                        @endif
                    </tr>
                @endforeach


                    </tbody>
                </table>

            </div>
        </div>
@endsection
