<div class="modal fade" id="author-modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <form name="authorForm" class="form-horizontal">
                    <input type="hidden" name="author_id" id="author_id">
                    <div class="form-group">
                        <label for="surname" class="col-sm-2">Surname</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="surname" name="surname" placeholder="Enter surname">
                            <span id="surnameError" class="text-danger"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-2">Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter name">
                            <span id="nameError" class="text-danger"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="patronymic" class="col-sm-2">Patronymic</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="patronymic" name="patronymic" placeholder="Enter patronymic">
                            <span id="patronymicError" class="text-danger"></span>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="createAuthor()">Save</button>
            </div>
        </div>
    </div>
</div>
