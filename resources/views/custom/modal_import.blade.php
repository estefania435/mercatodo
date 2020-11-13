<div class="modal" tabindex="-1" id="importModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Import</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="importProducts" action="{{ route('products.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" name="importFile" id="importFile">
                        <label class="custom-file-label" for="importFile">Seleccione archivo</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" form="importProducts" class="btn btn-primary" >Save changes</button>
            </div>
        </div>
    </div>
</div>
<button type="button" class="m-2 float-left btn btn-success" data-toggle="modal" data-target="#importModal">
    Import
</button>
