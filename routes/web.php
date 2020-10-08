<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'SiteController@index');

Route::resource('books', 'BooksController');
Route::resource('authors', 'AuthorsController');
