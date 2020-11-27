<div class="modal" tabindex="-1" id="searchProductsAdminModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Search</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-inline">
                    <select name="searchbyisInactive" class="form-control select2" style="width: 50%;">
                        <option value="inactive">Inactive</option>
                        <option value="active">Active</option>
                        <option selected></option>
                    </select>

                    <select name="searchbycategory" class="form-control select2" style="width: 50%;">
                        @foreach($category as $c)
                            <option selected></option>
                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                        @endforeach
                    </select>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                    </div>
                </form>

            </div>

        </div>
    </div>
</div>
<button type="button" class="m-2 float-right btn btn-primary" data-toggle="modal" data-target="#searchProductsAdminModal">
    Search
</button>
