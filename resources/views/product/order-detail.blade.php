@extends('layouts.master')

@section('content')
    <div class="container text-center">
        <div class="page-header">
            <h1><i class="fa fa-shopping-cart"> </i>Detalle del pedido</h1>
        </div>
        <div class="page">
            <div class="table-responsive">
                <h3>Datos del usuario</h3>
                <form action="{{ route('cart.Datesreceive')}}" method="POST">
                    @csrf

                    <label for="name_receive" class="col-md-4 col-form-label text-center">{{ __('Name') }}</label>

                    <input id="name_receive" type="text"
                           class="form-control valSoloTexto valCaracteresRepetidos valCaracteresInvalidos @error('name_receive') is-invalid @enderror"
                           name="name_receive" value="{{ Auth::user()->name }}" required
                           autocomplete="name_receive" autofocus minlength="3" maxlength="30">

                    @error('name_receive')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror

                    <label for="surname"
                           class="col-md-4 col-form-label text-center">{{ __('Surname') }}</label>

                    <input id="surname" type="text"
                           class="form-control valSoloTexto valCaracteresRepetidos valCaracteresInvalidos @error('surname') is-invalid @enderror"
                           name="surname" value="{{ Auth::user()->surname }}" required
                           autocomplete="surname" autofocus minlength="4" maxlength="30">

                    @error('surname')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror


                    <label for="address"
                           class="col-md-4 col-form-label text-centert">{{ __('address') }}</label>
                    <input id="address" type="text"
                           class="form-control @error('address') is-invalid @enderror"
                           name="address" value="{{ Auth::user()->address }}" required
                           autocomplete="address" autofocus minlength="15" maxlength="50">

                    @error('address')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror

                    <label for="phone"
                           class="col-md-4 col-form-label text-centert">{{ __('Phone') }}</label>
                    <input id="phone" type="text"
                           class="form-control valSoloNumero @error('phone') is-invalid @enderror"
                           name="phone" value="{{ Auth::user()->phone }}" required
                           autocomplete="phone" autofocus minlength="7" maxlength="10">

                    @error('phone')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror


                    <br>
                    <div class="table-responsive">
                        <h3>Datos del pedido</h3>
                        <table class="table table-striped table-hover table-bordered">
                            <tr>
                                <th>Producto</th>
                                <th>Precio</th>
                                <th>Cantidad</th>
                                <th>Subtotal</th>
                            </tr>
                            @foreach($cart as $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td>${{ number_format($item->price,2) }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>${{ number_format($item->price * $item->quantity,2) }}</td>
                                </tr>
                            @endforeach
                        </table>
                        <hr>
                        <h3>

                        </h3>
                        <hr>
                        <p>
                            <a href="{{ route('cart.show') }}" class="btn btn-primary">
                                <i class="fa fa-chevron-circle-left"></i> Regresar
                            </a>

                            <input class="btn btn-primary" type="submit" value="Save">


                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
