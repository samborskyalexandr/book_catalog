$.ajaxSetup({
    beforeSend: function (xhr)
    {
        xhr.setRequestHeader("X-CSRF-TOKEN",$('meta[name="csrf-token"]').attr('content'));
    }
});

$(document).ready(function() {
    $('.authors-select').select2({
        tags: true,
        width: '100%'
    });
});

function addBook() {
    $("#book_id").val('');
    $('#book-modal').modal('show');
}

function editBook(event) {
    event = event.closest('button');

    let id  = $(event).data("id");
    let _url = "/books/" + id;
    $('#nameError').text('');
    $('#descriptionError').text('');
    $('#authorsError').text('');
    $('#publication_dateError').text('');
    $('#posterError').text('');

    $.ajax({
        url: _url,
        type: "GET",
        success: function(response) {
            if(response) {
                $("#book_id").val(response.book.id);
                $("#name").val(response.book.name);
                $("#description").val(response.book.description);
                $('.authors-select').val(response.authors).trigger('change');
                $('#publication_date').val(response.publication_date);
                $('#poster_preview').attr('src', response.book.image_src);
                $('#book-modal').modal('show');
            }
        },
        error: function(response) {
            $('#nameError').text(response.responseJSON.errors.name);
            $('#descriptionError').text(response.responseJSON.errors.description);
            $('#authorsError').text(response.responseJSON.errors.authors);
            $('#publication_dateError').text(response.responseJSON.errors.publication_date);
            $('#posterError').text(response.responseJSON.errors.poster);
        }
    });
}

$(document).on("submit", "#bookForm", function (e) {
    e.preventDefault();
    $('#nameError').text('');
    $('#descriptionError').text('');
    $('#authorsError').text('');
    $('#publication_dateError').text('');
    $('#posterError').text('');

    let id = $('#book_id').val();
    let form = new FormData();

    form.append('book_id', id);
    form.append('name', $('#name').val());
    form.append('description', $('#description').val());
    form.append('authors', $('#authors').val());
    form.append('publication_date', $('#publication_date').val());
    form.append('poster', $('#poster')[0].files[0]);

    let _url = `/books`;

    $.ajax({
        type: "POST",
        url: _url,
        data: form,
        cache:false,
        contentType: false,
        processData: false,
        success: function(response) {
            if(response.code == 200) {
                if(id != ""){
                    $("#row_"+id+" td:nth-child(1)").html('<div class="d-flex justify-content-center"><img src="' + response.book.image_src + '" class="w-100" alt=""></div>');
                    $("#row_"+id+" td:nth-child(2)").html(response.book.name);
                    $("#row_"+id+" td:nth-child(3)").html(response.book.description);
                    $("#row_"+id+" td:nth-child(4)").html(response.authors);
                    $("#row_"+id+" td:nth-child(5)").html(response.book.publication_date);
                } else {
                    $('table tbody').prepend(
                        '<tr id="row_' + response.book.id + '">' +
                        '<td><div class="d-flex justify-content-center"><img src="' + response.book.image_src + '" class="w-100" alt=""></div></td>' +
                        '<td>' + response.book.name + '</td>' +
                        '<td>' + response.book.description + '</td>' +
                        '<td>' + response.authors + '</td>' +
                        '<td>' + response.book.publication_date + '</td>' +
                        '<td>' +
                        '<button class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Edit" data-id="' + response.book.id + '" onclick="editAuthor(event.target)"><i class="fa fa-pencil" aria-hidden="true"></i></button> ' +
                        '<button class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Delete" data-id="' + response.book.id + '" onclick="deleteAuthor(event.target)"><i class="fa fa-trash" aria-hidden="true"></i></button>' +
                        '</td>' +
                        '</tr>');
                }
                $('#name').val('');
                $('#description').val('');
                $('.authors-select').val(null).trigger('change');
                $("#authors").val('');
                $('#publication_date').val('');
                $('#poster').val('');

                $('#book-modal').modal('hide');

                if ($("#no-data").length > 0) {
                    $("#no-data").remove();
                }

                $.notify({
                    message: response.message
                },{
                    type: 'success',
                    delay: 4000,
                });
            }
        },
        error: function(response) {
            $('#nameError').text(response.responseJSON.errors.name);
            $('#descriptionError').text(response.responseJSON.errors.description);
            $('#authorsError').text(response.responseJSON.errors.authors);
            $('#publication_dateError').text(response.responseJSON.errors.publication_date);
            $('#posterError').text(response.responseJSON.errors.poster);
        }
    });
});

$(document).on("change", "#poster", function() {
    let reader = new FileReader();
    reader.onload = (e) => {
        $('#poster_preview').attr('src', e.target.result);
    };
    reader.readAsDataURL(this.files[0]);
});

function deleteBook(event) {
    event = event.closest('button');
    let id  = $(event).data("id");
    let _url = "/books/" + id;
    if (confirm('Are you sure you want to delete this book')) {
        $.ajax({
            url: _url,
            type: 'DELETE',
            success: function (response) {
                $("#row_" + id).remove();
                if (!$("#no-data").length > 0 && $('tbody tr').length < 1) {
                    $('table tbody').prepend('<tr id="no-data"><td colspan="6">No data</td></tr>');
                }
                $.notify({
                    message: response.message
                }, {
                    type: 'success',
                    delay: 4000,
                });
            }
        });
    }
}

$(document).on("keypress","#nameFilter",function(event) {
    getFilterParams(event);
});

function getFilterParams(event) {
    if (event.which == 13) {
        let name = $('#nameFilter').val();
        filterData(name);
        event.preventDefault();
    }
}

function filterData(name) {
    let _url = "/books?name=" + name;
    window.location.replace(_url);
}
