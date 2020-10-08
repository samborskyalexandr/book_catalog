@extends('layout')

@push('styles')
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ asset('js/books.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>
@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>
                            Books
                        </span>
                        <div>
                            <a href="/books" class="btn btn-success">Reset filters</a>
                            <div class="btn btn-info" onclick="addBook()">Create new</div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="books-table" class="table table-sm table-bordered table-striped display" style="table-layout: fixed !important;">
                            <thead>
                            <tr>
                                <th width="15%">
                                    Poster
                                </th>
                                <th width="15%">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="mr-2 w-50">@sortablelink('name')</div>
                                        <input type="text" class="form-control w-50" id="nameFilter" name="nameFilter" placeholder="" value="{{ $name }}">
                                    </div>
                                </th>
                                <th width="25%">
                                    Description
                                </th>
                                <th width="10%">
                                    Authors
                                </th>
                                <th width="10%">
                                    Publication Date
                                </th>
                                <th width="10%">
                                    Action
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($books->count())
                                @foreach($books as $book)
                                    <tr id="row_{{$book->id}}">
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <img src="{{ $book->image_src ? asset($book->image_src) : asset('img/poster-placeholder.svg') }}" class="w-100" alt="">
                                            </div>
                                        </td>
                                        <td>{{ $book->name }}</td>
                                        <td>{{ $book->description }}</td>
                                        <td>
                                            @foreach ($book->authors as $author)
                                                {{ $author->surname . ' ' . $author->name . ' ' . $author->patronymic }} <br>
                                            @endforeach
                                        </td>
                                        <td>{{ $book->publication_date ? date('d.m.Y', strtotime($book->publication_date)) : '' }}</td>
                                        <td>
                                            <button class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Edit" data-id="{{ $book->id }}" onclick="editBook(event.target)">
                                                <i class="fa fa-pencil" aria-hidden="true"></i>
                                            </button>
                                            <button class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Delete" data-id="{{ $book->id }}" onclick="deleteBook(event.target)">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr id="no-data">
                                    <td colspan="6">No data</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                        {!! $books->appends(\Request::except('page'))->render() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('books.create-edit-modal')
@endsection
