$.ajaxSetup({
    beforeSend: function (xhr)
    {
        xhr.setRequestHeader("X-CSRF-TOKEN",$('meta[name="csrf-token"]').attr('content'));
    }
});

function addAuthor() {
    $("#author_id").val('');
    $('#author-modal').modal('show');
}

function editAuthor(event) {
    event = event.closest('button');

    let id  = $(event).data("id");
    let _url = "/authors/" + id;
    $('#surnameError').text('');
    $('#nameError').text('');
    $('#patronymicError').text('');

    $.ajax({
        url: _url,
        type: "GET",
        success: function(response) {
            if(response) {
                $("#author_id").val(response.id);
                $("#surname").val(response.surname);
                $("#name").val(response.name);
                $("#patronymic").val(response.patronymic);
                $('#author-modal').modal('show');
            }
        },
        error: function(response) {
            $('#surnameError').text(response.responseJSON.errors.surname);
            $('#nameError').text(response.responseJSON.errors.name);
            $('#patronymicError').text(response.responseJSON.errors.patronymic);
        }
    });
}

function createAuthor() {
    $('#surnameError').text('');
    $('#nameError').text('');
    $('#patronymicError').text('');

    let surname = $('#surname').val();
    let name = $('#name').val();
    let patronymic = $('#patronymic').val();
    let id = $('#author_id').val();

    let _url = `/authors`;

    $.ajax({
        url: _url,
        type: "POST",
        dataType: "json",
        data: {
            id: id,
            surname: surname,
            name: name,
            patronymic: patronymic
        },
        success: function(response) {
            if(response.code == 200) {
                patronymic = response.data.patronymic == null ? '' : response.data.patronymic;
                if(id != ""){
                    $("#row_"+id+" td:nth-child(1)").html(response.data.surname);
                    $("#row_"+id+" td:nth-child(2)").html(response.data.name);
                    $("#row_"+id+" td:nth-child(3)").html(patronymic);
                } else {
                    $('table tbody').prepend(
                        '<tr id="row_'+response.data.id+'">' +
                                    '<td>'+response.data.surname+'</td>' +
                                    '<td>'+response.data.name+'</td>' +
                                    '<td>'+patronymic+'</td>' +
                                    '<td>' +
                                        '<button class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Edit" data-id="' + response.data.id + '" onclick="editAuthor(event.target)"><i class="fa fa-pencil" aria-hidden="true"></i></button> ' +
                                        '<button class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Delete" data-id="' + response.data.id + '" onclick="deleteAuthor(event.target)"><i class="fa fa-trash" aria-hidden="true"></i></button>' +
                                    '</td>' +
                                '</tr>');
                }
                $('#surname').val('');
                $('#name').val('');
                $('#patronymic').val('');

                $('#author-modal').modal('hide');

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
            $('#surnameError').text(response.responseJSON.errors.surname);
            $('#nameError').text(response.responseJSON.errors.name);
            $('#patronymicError').text(response.responseJSON.errors.patronymic);
        }
    });
}

function deleteAuthor(event) {
    event = event.closest('button');
    let id  = $(event).data("id");
    let _url = "/authors/" + id;
    if (confirm('Are you sure you want to delete this author')) {
        $.ajax({
            url: _url,
            type: 'DELETE',
            success: function (response) {
                if (response.status == 'success') {
                    $("#row_" + id).remove();
                    if (!$("#no-data").length > 0 && $('tbody tr').length < 1) {
                        $('table tbody').prepend('<tr id="no-data"><td colspan="4">No data</td></tr>');
                    }
                }
                $.notify({
                    message: response.message
                }, {
                    type: response.status,
                    delay: 4000,
                });
            }
        });
    }
}

$(document).on("keypress","#surnameFilter",function(event) {
    getFilterParams(event);
});

$(document).on("keypress","#nameFilter",function(event) {
    getFilterParams(event);
});

function getFilterParams(event) {
    if (event.which == 13) {
        let name = $('#nameFilter').val();
        let surname = $('#surnameFilter').val();
        filterData(name, surname);
        event.preventDefault();
    }
}

function filterData(name, surname) {
    let _url = "/authors?name=" + name + "&surname=" + surname;
    window.location.replace(_url);
}
