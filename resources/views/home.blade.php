@extends('layouts.master')

@section('content')
    <div class="container">
        <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
            <h1 class="display-4">Ofertas</h1>

            <p class="lead">Quickly build an effective pricing table for your potential customers with this Bootstrap
                example.
                It’s built with default Bootstrap components and utilities with little customization.</p>
        </div>
        <!---->

        <!-- -->
        <div class="container">
            <div class="row mb-2">

                <div class="col-md-6">
                    <div
                        class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                        <div class="col p-4 d-flex flex-column position-static">
                            <strong class="d-inline-block mb-2 text-primary">World</strong>
                            <h3 class="mb-0">Featured post</h3>
                            <div class="mb-1 text-muted">Nov 12</div>
                            <p class="card-text mb-auto">This is a wider card with supporting text below as a natural
                                lead-in to
                                additional content.</p>
                            <a href="#" class="stretched-link">Continue reading</a>
                        </div>
                        <div class="col-auto d-none d-lg-block">
                            <img class="bd-placeholder-img"
                                 src="https://ar.zoetis.com/_locale-assets/mcm-portal-assets/publishingimages/especie/caninos_perro_img.png"
                                 width="200" height="250" title="Cat">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div
                        class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                        <div class="col p-4 d-flex flex-column position-static">
                            <strong class="d-inline-block mb-2 text-success">Design</strong>
                            <h3 class="mb-0">Post title</h3>
                            <div class="mb-1 text-muted">Nov 11</div>
                            <p class="mb-auto">This is a wider card with supporting text below as a natural lead-in to
                                additional content.</p>
                            <a href="#" class="stretched-link">Continue reading</a>
                        </div>
                        <div class="col-auto d-none d-lg-block">
                            <img class="bd-placeholder-img"
                                 src="https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcTpoO0qDvr9EDCnbtzgDoqAL5wUTFkqoj_MlA&usqp=CAU"
                                 width="200" height="250" title="Cat">
                        </div>
                    </div>
                </div>
            </div>

            <!---->

            <!---->
            <div class="album py-5 bg-light">
                <div class="container">

                    <div class="row">
                        @foreach($products as $item)
                            @if($item->quantity>0)
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
                                            <td><a class="btn btn-default"
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


