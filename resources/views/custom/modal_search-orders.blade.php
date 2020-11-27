<div class="modal" tabindex="-1" id="searchOrdersModal">
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
                    <select name="searchbystate" class="form-control select2" style="width: 50%;">
                        <option value="OPEN">OPEN</option>
                        <option value="PENDING">PENDING</option>
                        <option value="APPROVED">APPROVED</option>
                        <option value="REJECTED">REJECTED</option>
                        <option selected></option>
                    </select>
                    <input name="searchbydate" class="form-control mr-sm-2" type="search" placeholder="Date AA-MM-DD" aria-label="Search">

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                    </div>
                </form>

            </div>

        </div>
    </div>
</div>
<button type="button" class="m-2 float-left btn btn-primary" data-toggle="modal" data-target="#searchOrdersModal">
    Search
</button>
