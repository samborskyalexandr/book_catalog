<div class="modal fade" id="book-modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"></h4>
            </div>
            <form method="POST" enctype="multipart/form-data" id="bookForm" class="form-horizontal" action="javascript:void(0)">
                <div class="modal-body">
                    <input type="hidden" name="book_id" id="book_id">
                    <div class="form-group">
                        <label for="name" class="col-sm-6">Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter name">
                            <span id="nameError" class="text-danger"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description" class="col-sm-6">Description</label>
                        <div class="col-sm-12">
                            <textarea id="description" class="form-control" rows="6" cols="45" name="description"></textarea>
                            <span id="descriptionError" class="text-danger"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="authors" class="col-sm-6">Authors</label>
                        <div class="col-sm-12">
                            <select id="authors" name="authors" class="authors-select custom-select form-control" multiple="multiple">
                                @foreach($authors as $id => $author)
                                    <option value="{{ $id }}">{{ $author }}</option>
                                @endforeach
                            </select>
                            <span id="authorsError" class="text-danger"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="publication_date" class="col-sm-6">Publication date</label>
                        <div class="col-sm-12">
                            <input type="date" name="publication_date" id="publication_date" class="form-control">
                            <span id="publication_dateError" class="text-danger"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="poster" class="col-sm-6">Poster</label>
                        <div class="col-sm-12">
                            <input type="file" id="poster" name="poster">
                        </div>
                        <div id="posterError" class="text-danger col-sm-12"></div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <img id="poster_preview" src="" class="w-100" alt="">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" >Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
