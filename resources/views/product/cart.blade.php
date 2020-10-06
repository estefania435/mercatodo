@extends('layouts.master')

@section('content')
    <div class="container text-center">
        <div class="page-header">
            <h1><i class="fa fa-shopping-cart"> </i>carrito de compras</h1>
        </div>
        <div class="page">

                @if($cart)
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
                            @foreach($cart->details as $item)
                                <tr>
                                    @foreach ($item->products->images as $c)
                                        <td><img class="bd-placeholder-img"
                                                 src="{{ $c->url }}"
                                                 width="267" height="225" title="Pets"></td>
                                    @endforeach
                                    <td>{{ $item->products->name}}</td>
                                    <td>${{ number_format($item->products->price,2) }}</td>
                                    <td>
                                        <input
                                            type="number"
                                            min="1"
                                            max="100"
                                            value="{{ $item->quantity }}"
                                            id="product_{{ $item->products->id }}"
                                            onchange="updateProductCart(this.value, '{{ route('cart.update', $item->products->slug) }}');"
                                        >

                                    </td>
                                    <td>${{ number_format($item->products->price * $item->quantity,2) }}</td>
                                    <td>
                                        <a href="{{ route('cart.delete', $item->products->id) }}"
                                           class="btn btn-danger">
                                            <i class="fas fa-trash-alt"></i>

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
                     Continuar
                    <i class="fa fa-chevron-circle-right"></i>
                </a>

            </p>
                    <a href="{{ route('cart.trash') }}" class="btn btn-danger">Vaciar carrito
                        <i class="fas fa-trash-alt"></i>
                    </a>
        </div>
    </div>
@stop
