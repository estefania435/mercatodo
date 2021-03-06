@extends('plantilla.admin')

@section('title','Edit category')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.category.index') }}">Categories</a></li>
    <li class="breadcrumb-item active">@yield('title')</li>
@endsection

@section('content')

<div id="apicategory">

        <form action="{{ route('admin.category.update',$cat->id)}}" method="POST">
        @csrf
            @method('PUT')



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

                               class="form-control valCaracteresRepetidos" type="text" name="name" id="name" maxlength="20">
                        <label for="slug">Slug</label>
                        <input readonly v-model="generateSlug" class="form-control" type="text" name="slug" id="slug">
                        <div v-if="div_appear" v-bind:class="div_class_slug">
                            @{{div_messageslug}}
                        </div>
                        <br v-if="div_appear">
                        <label for="description">Description</label>
                        <textarea class="form-control" name="description"
                        id="description" cols="30" rows="5" minlength="15">{{ $cat ->description}}</textarea>

                    </div>

    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        <a class="btn btn-danger" href="{{ route('cancel','admin.category.index') }}">Cancel</a>

        <input
            :disabled="disable_button==1"
            type="submit" value="Save" class="btn btn-primary float-right">

    </div>
    <!-- /.card-footer-->
</div>
<!-- /.card -->
        </form>
    </div>
@endsection
