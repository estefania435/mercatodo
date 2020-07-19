@extends('plantilla.admin')

@section('title', 'Create Product')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('admin.product.index')}}">Products</a></li>
    <li class="breadcrumb-item active">@yield('title')</li>
@endsection

@section('content')

    <div id="apiproduct">

    <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data" >
    @csrf

    <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- SELECT2 EXAMPLE -->

                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Automatically generated data</h3>

                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">

                                    <label>Visits</label>
                                    <input  class="form-control" type="number" id="visits" name="visits">

                                </div>
                                <!-- /.form-group -->

                            </div>
                            <!-- /.col -->
                            <div class="col-md-6">
                                <div class="form-group">

                                    <label>Sales</label>
                                    <input  class="form-control" type="number" id="sales" name="sales" >
                                </div>
                                <!-- /.form-group -->

                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->

                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">

                    </div>
                </div>
                <!-- /.card -->

                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Product dates</h3>

                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">

                                    <label>Name</label>
                                    <input

                                    v-model="name"
                                    @blur="getProduct"
                                    @focus="div_appear= false"

                                    class="form-control" type="text" id="name" name="name">

                                    <label>Slug</label>
                                    <input
                                    readonly
                                    v-model="generateSlug"

                                    class="form-control" type="text" id="slug" name="slug" >

                                    <div v-if="div_appear" v-bind:class="div_class_slug">
                                        @{{div_messageslug}}
                                    </div>
                                    <br v-if="div_appear">

                                </div>
                                <!-- /.form-group -->

                            </div>
                            <!-- /.col -->
                            <div class="col-md-6">
                                <div class="form-group">

                                    <label>category</label>
                                    <select name="category_id" class="form-control select2" style="width: 100%;">
                                        @foreach($categories as $category)

                                            @if ($loop->first)
                                                <option value="{{ $category->id }}" selected="selected">{{ $category->name }}</option>
                                            @else
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endif
                                        @endforeach

                                    </select>
                                    <label>Quantity</label>
                                    <input class="form-control" type="number" id="quantity" name="quantity" >
                                </div>
                                <!-- /.form-group -->

                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->

                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">

                    </div>
                </div>

                <!-- /.card -->

                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Pricing Section</h3>

                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-3">
                                <div class="form-group">

                                    <label>Price</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">$</span>
                                        </div>
                                        <input class="form-control" type="number" id="price" name="price" min="0" value="0" step=".01">
                                    </div>

                                </div>
                                <!-- /.form-group -->

                            </div>
                            <!-- /.col -->

                        </div>
                        <!-- /.row -->

                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">

                    </div>
                </div>
                <!-- /.card -->

                <div class="row">
                    <div class="col-md-6">

                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Product descriptions</h3>
                            </div>
                            <div class="card-body">

                                <div class="form-group">
                                    <label>Description:</label>

                                    <textarea class="form-control" name="description" id="description" rows="5"></textarea>

                                </div>

                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->

                    </div>
                    <!-- /.col-md-6 -->

                    <div class="col-md-6">

                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Specifications and other data</h3>
                            </div>
                            <div class="card-body">
                                <!-- Date dd/mm/yyyy -->
                                <div class="form-group">
                                    <label>Specifications:</label>

                                    <textarea class="form-control" name="specifications" id="specifications" rows="3"></textarea>

                                </div>
                                <!-- /.form group -->

                                <div class="form-group">
                                    <label>Data of interest:</label>

                                    <textarea class="form-control" name="data-of-interest" id="data-of-interest" rows="5"></textarea>

                                </div>

                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->

                    </div>
                    <!-- /.col-md-6 -->

                </div>
                <!-- /.row -->

                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title">Images</h3>

                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <div class="form-group">

                            <label for="imagefiles">Upload multiple images</label>

                            <input type="file" class="form-control-file" id="imagefiles[]" multiple
                                   accept="image/*" >
                        </div>

                    </div>

                    <!-- /.card-body -->
                    <div class="card-footer">

                    </div>
                </div>
                <!-- /.card -->

                <div class="card card-danger">
                    <div class="card-header">
                        <h3 class="card-title">Administration</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">

                                    <label>Status</label>
                                    <input  class="form-control" type="text" id="status" name="status" value="New">


                                </div>
                                <!-- /.form-group -->

                            </div>
                            <!-- /.col -->
                            <div class="col-sm-6">
                                <!-- checkbox -->
                                <div class="form-group clearfix">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="active" name="active">
                                        <label class="custom-control-label" for="active">Active</label>
                                    </div>

                                </div>

                            </div>

                        </div>
                        <!-- /.row -->

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">

                                    <a class="btn btn-danger" href="{{ route('cancel','admin.product.index') }}">cancel</a>
                                    <input
                                        :disabled="disable_button==1"

                                        type="submit" value="Save" class="btn btn-primary">

                                </div>
                                <!-- /.form-group -->

                            </div>
                            <!-- /.col -->

                        </div>
                        <!-- /.row -->

                    </div>

                </div>
                <!-- /.card -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->

    </form>

    </div>

@endsection
