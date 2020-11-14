<div class="modal" tabindex="-1" id="exportModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Export</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="exportProducts" action="{{ route('products.export') }}"  enctype="multipart/form-data">

                    <select id="extension" name="extension" >

                        @foreach(App\Constants\ExportExtensions::EXTENSIONS as $extension)

                            <option value="{{ $extension }}">{{ $extension }}</option>
                        @endforeach

                    </select>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" form="exportProducts" class="btn btn-primary" >Export</button>
            </div>
        </div>
    </div>
</div>
<button type="button" class="m-2 float-left btn btn-success" data-toggle="modal" data-target="#exportModal">
    Export
</button>
