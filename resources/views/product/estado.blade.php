@extends('layouts.master')

@section('content')
<div class="container text-center">
    <div class="page-header">
        <h1><i class="fas fa-money-check-alt"></i>Estado del pago</h1>

        <span style="display:none;" id="urlbase">{{route('pay.show')}}</span>
        <div class="table-responsive">

            <table class="table table-striped table-hover table-bordered">
                <thead>
                <tr>
                    <th>Status</th>
                    <th>Payment Method</th>
                    <th>Name</th>
                    <th>Surname</th>
                    <th>Total</th>


                </tr>
                </thead>
                <tbody>

                <td>{{ $payment->status }}</td>
                <td>{{ $payment->payment_method }}</td>
                <td>{{ $payment->name }}</td>
                <td>{{ $payment->surname }}</td>
                <td>{{ $payment->order_total}}</td>




                </tbody>
            </table>
            @if($payment->status== 'REJECTED')
            <p>
                <a href="{{ route('pay.repay', $payment->reference) }}" class="btn btn-info">
                    Reintentar pago
                </a>
            </p>
            @endif
    </div>
</div>
@endsection
