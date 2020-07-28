@extends('layouts.master')

@section('content')
    <div class="container">
        <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
            <h1 class="display-4">Ofertas</h1>

            <p class="lead">En esta sección encontrarás los productos en oferta</p>
        </div>
        <!---->

        <!-- -->
        <div class="container">
            <div class="row mb-2">

                <div class="col-md-6">
                    <div
                        class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                        @foreach($products as $item)
                            @if($item->quantity>0 & $item->status=='Offer')
                        <div class="col p-4 d-flex flex-column position-static">
                            <h3 class="mb-0">{{ $item->name }}</h3>
                            <p class="mb-auto">{{ $item->description }}</p>
                            <p class="card-text">{{ $item->price }}</p>
                            <div class="btn-group">
                                <td><a class="btn btn-sm btn-outline-secondary"
                                       href="{{ route('product.show',$item->id) }}">See</a></td>
                                <button type="button" class="btn btn-sm btn-outline-secondary">Agregar al
                                    carrito
                                </button>
                            </div>
                        </div>
                        <div class="col-auto d-none d-lg-block">
                            <img class="bd-placeholder-img"
                                 src="{{ $item->images->random()->url }}"
                                 width="267" height="225" title="Pets">


                        </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>

            <!---->

            <!---->
            <div class="album py-5 bg-light">
                <div class="container">

                    <div class="row">
                        @foreach($products as $item)
                            @if($item->quantity>0& $item->status=='New')
                        <div class="col-md-4">
                            <div class="card mb-4 shadow-sm">
                                <img class="bd-placeholder-img"
                                     src="{{ $item->images->random()->url }}"
                                     width="267" height="225" title="Pets">
                                <div class="card-body">
                                    <p class="card-text">{{ $item->name }}</p>
                                    <p class="card-text">{{ $item->description }}</p>
                                    <p class="card-text">{{ $item->price }}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="btn-group">
                                            <td><a class="btn btn-sm btn-outline-secondary"
                                                   href="{{ route('product.show',$item->id) }}">See</a></td>
                                            <button type="button" class="btn btn-sm btn-outline-secondary">Agregar al
                                                carrito
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                            @endif
                        @endforeach

                    </div>
                </div>
            </div>
            <!---->

        </div>
    <!--
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
        <div class="alert alert-success" role="alert">
{{ session('status') }}
            </div>
@endif

        You are logged in!
    </div>
</div>
</div>
</div>-->
    </div>
@endsection


