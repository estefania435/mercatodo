@extends('layouts.master')

@section('title', 'Show Product')

<script src="/admin-lte/plugins/ekko-lightbox/ekko-lightbox.min.js"></script>


@section('content')

            <div class="container-fluid">

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <h2>
                                        {{ $product->name }}
                                    </h2>
                                </div>
                            </div>
                        </div>
                    </div>
                <div class="card card-primary">
                    <div class="card-body">
                        <div class="row">

                            @foreach ($product->images as $image)
                                <div class="col-sm-2">
                                    <a href="{{ $image->url }}" data-toggle="lightbox"
                                       data-title="Id:{{ $image->id }}" data-gallery="gallery">
                                        <img src="{{ $image->url }}" class="img-fluid mb-2"/>
                                    </a>
                                    <br>
                                    <a style="display: none" href="{{ $image->url }}">
                                        <i class="fas fa-trash-alt" style="color:red"></i>
                                    </a>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>

            </div>

    <div class="">
        <div class="col-md-6">
            <div class="card-body">

                <div class="form-group">

                    <label>Price:</label>
                    {{ $product->price }}

                    <br>

                    <label>Description:</label>
                    {{ $product->description }}

                    <br>

                    <label>Specifications:</label>
                    {{ $product->specifications }}

                    <br>

                    <label>Data of interest:</label>
                    {{ $product->data_of_interest }}

                </div>
            </div>

        </div>

    </div>

@endsection
