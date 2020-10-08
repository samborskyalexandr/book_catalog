@extends('layout')

@push('scripts')
    <script src="{{ asset('js/authors.js') }}"></script>
@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>
                            Authors
                        </span>
                        <div>
                            <a href="/authors" class="btn btn-success">Reset filters</a>
                            <div class="btn btn-info" onclick="addAuthor()">Create new</div>
                        </div>
                    </div>

                    <div class="card-body">
                        <table id="authors-table" class="table table-bordered table-striped display" style="table-layout: fixed !important;">

                                <thead>
                                    <tr>
                                        <th width="27%">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="mr-2 w-50">@sortablelink('surname')</div>
                                                <input type="text" class="form-control w-50" id="surnameFilter" name="surnameFilter" placeholder="" value="{{ $surname }}">
                                            </div>
                                        </th>
                                        <th width="27%">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="mr-2 w-50">Name</div>
                                                <input type="text" class="form-control w-50" id="nameFilter" name="nameFilter" placeholder="" value="{{ $name }}">
                                            </div>
                                        </th>
                                        <th width="27%">
                                            Patronymic
                                        </th>
                                        <th width="19%">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if($authors->count())
                                    @foreach($authors as $author)
                                        <tr id="row_{{$author->id}}">
                                            <td>{{ $author->surname }}</td>
                                            <td>{{ $author->name }}</td>
                                            <td>{{ $author->patronymic }}</td>
                                            <td>
                                                <button class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Edit" data-id="{{ $author->id }}" onclick="editAuthor(event.target)">
                                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                                </button>
                                                <button class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Delete" data-id="{{ $author->id }}" onclick="deleteAuthor(event.target)">
                                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr id="no-data">
                                        <td colspan="4">No data</td>
                                    </tr>
                                @endif
                                </tbody>

                        </table>
                        {!! $authors->appends(\Request::except('page'))->render() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('authors.create-edit-modal')
@endsection
