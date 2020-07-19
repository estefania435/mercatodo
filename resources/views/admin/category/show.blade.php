@extends('plantilla.admin')

@section('title','Show category')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.category.index') }}">Categories</a></li>
    <li class="breadcrumb-item active">@yield('title')</li>
@endsection

@section('content')

<div id="apicategory">

        <form>
        @csrf




            <span style="display:none;" id="edit">{{$edit}}</span>
            <span style="display:none;" id="nametemp">{{$cat->name}}</span>

        <!-- Default box -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Administration of categories</h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                <i class="fas fa-times"></i></button>
        </div>
    </div>
    <div class="card-body">





                    <div class="form-group">
                        <label for="name">Name</label>
                        <input v-model="name"

                               @blur="getCategory"
                               @focus="div_appear= false"
                               readonly

                               class="form-control" type="text" name="name" id="name"
                               value="{{ $cat->name }}" readonly>


                        <label for="slug">Slug</label>
                        <input  v-model="generateSlug" class="form-control" type="text" name="slug" id="slug"
                        value="{{ $cat->slug }}" readonly>


                        <label for="description">Description</label>
                        <textarea class="form-control" name="description"
                        id="description" cols="30" rows="5" readonly>{{ $cat ->description}}</textarea>

                    </div>

    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        <a class="btn btn-danger" href="{{ route('cancel','admin.category.index') }}">Cancel</a>

        <a class="btn btn-success float-right" href="{{ route('admin.category.edit',$cat->slug) }}">Edit</a>


    </div>
    <!-- /.card-footer-->
</div>
<!-- /.card -->
        </form>
    </div>
@endsection
