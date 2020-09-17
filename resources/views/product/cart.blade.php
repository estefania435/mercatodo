@extends('layouts.master')

@section('content')
    <div class="container text-center">
        <div class="page-header">
            <h1><i class="fa fa-shopping-cart"> </i>carrito de compras</h1>
        </div>
        <div class="page">
            @if(count($cart))
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered">
                        <thead>
                        <tr>
                            <th>Image</th>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                            <th>Delete</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($cart as $item)
                            <tr>
                                <td><img class="bd-placeholder-img"
                                         src="{{ $item->image }}"
                                         width="267" height="225" title="Pets"></td>
                                <td>{{ $item->name }}</td>
                                <td>${{ number_format($item->price,2) }}</td>
                                <td>
                                    <input
                                        type="number"
                                        min="1"
                                        max="100"
                                        value="{{ $item->quantity }}"
                                        id="product_{{ $item->id }}"
                                        onchange="updateProductCart(this.value, '{{ route('cart.update', $item->slug) }}');"
                                    >

                                </td>
                                <td>${{ number_format($item->price * $item->quantity,2) }}</td>
                                <td>
                                    <a href="{{ route('cart.delete', $item->id) }}" class="btn btn-danger">
                                        <i class="fa fa-remove"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <hr>
                    <h3>
                        <span class="label label-success">
                            Total: ${{ number_format($total,2) }}
                        </span>
                    </h3>
                </div>
            @else
                <h3><span class="label label-warning">No hay productos en el carrito</span></h3>
            @endif
            <hr>
            <p>
                <a href="{{ route('home') }}" class="btn btn-primary">
                    <i class="fa fa-chevron-circle-left"></i> Seguir comprando
                </a>

                <a href="{{ route('order-detail') }}" class="btn btn-primary">
                    <i class="fa fa-chevron-circle-right"></i> Continuar
                </a>

                <a href="{{ route('cart.trash') }}" class="btn btn-primary">Vaciar carrito</a>
            </p>
        </div>
    </div>
@stop
