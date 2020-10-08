<?php

namespace App\Http\Controllers;

use App\Author;
use App\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class BooksController extends Controller
{
    public function index()
    {
        $query = Book::sortable()->with('authors');
        $nameQuery = '';
        $authorQuery = '';

        if (isset($_GET['author'])) {
            $authorQuery = $_GET['author'];

            if (!preg_match('//u', $authorQuery)) {
                $authorQuery = iconv("cp1251","UTF-8", $authorQuery);
            }
            $query->whereHas('authors', function ($q) use ($authorQuery) {
                foreach (explode(" ", $authorQuery) as $condition) {
                    $q->where('name', 'LIKE', '%' . $condition . '%');
                    $q->orWhere('surname', 'LIKE', '%' . $condition . '%');
                    $q->orWhere('patronymic', 'LIKE', '%' . $condition . '%');
                }
            });
        }

        if (isset($_GET['name'])) {
            $nameQuery = $_GET['name'];
            if (!preg_match('//u', $nameQuery)) {
                $nameQuery = iconv("cp1251","UTF-8", $nameQuery);
            }
            $query->where('name', 'LIKE', '%' . $nameQuery . '%');
        }

        $books = $query->paginate(15);

        $authors = Author::all();

        $authorsFullNames = [];
        foreach ($authors as $author) {
            $authorsFullNames[$author->id] = $author->surname . ' ' . $author->name . ' ' . $author->patronymic;
        }

        return view('books.list', [
            'books' => $books,
            'authors' => $authorsFullNames,
            'nameQuery' => $nameQuery,
            'authorQuery' => $authorQuery
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'max:255',
            'authors' => 'required'
        ]);

        $bookId = $request->book_id ? $request->book_id : 0;
        $imageSrc = $request->book_id ? Book::find($bookId)->image_src : null;

        if ($request->hasFile('poster')) {
            $request->validate([
                'poster' => 'image|mimes:jpeg,png,jpg|max:2048'
            ]);

            $path = storage_path() . '/app/public/book-posters/';
            $ext = $request->poster->getClientOriginalExtension();

            if ($ext == 'png') {
                $imageName = $bookId . '_' . bin2hex(random_bytes(10)).'.'.'png';
            } elseif ($ext == 'jpg') {
                $imageName = $bookId . '_' . bin2hex(random_bytes(10)).'.'.'jpg';
            } else {
                $imageName = $bookId . '_' . bin2hex(random_bytes(10)).'.'.'jpeg';
            }

            if(!File::isDirectory($path)) {
                File::makeDirectory($path, 0777, true, true);
            }

            $request->poster->storeAs('public/book-posters', $imageName);
            $imageSrc = 'storage/book-posters/' . $imageName;
        }

        $book = Book::updateOrCreate(['id' => $request->book_id], [
            'name' => $request->name,
            'description' => $request->description,
            'image_src' => $imageSrc,
            'publication_date' => $request->publication_date
        ]);

        $book->authors()->sync(explode(',', $request->authors));

        $book->publication_date = $book->publication_date ? date('d.m.Y', strtotime($book->publication_date)) : '';
        $book->description = $book->description ? $book->description : '';
        $book->image_src = $imageSrc ? asset($book->image_src) : asset('img/poster-placeholder.svg');

        $authors = '';
        foreach ($book->authors as $author) {
            $authors .= $author->surname . ' ' . $author->name . ' ' . $author->patronymic . '<br>';
        }

        $message = $bookId ? 'Book Updated successfully' : 'Book Created successfully';

        return response()->json([
            'code'=>200,
            'message' => $message,
            'book' => $book,
            'authors' => $authors
        ], 200);
    }

    public function show($id)
    {
        $book = Book::find($id);
        $authors = $book->authors;

        $authorsId = [];
        foreach ($authors as $author) {
            $authorsId[] = $author->id;
        }

        return response()->json([
            'book' => $book,
            'authors' => $authorsId
        ]);
    }

    public function destroy($id)
    {
        $book = Book::find($id);
        $book->authors()->detach();
        $book->delete();
        return response()->json([
            'message' => 'Book Deleted successfully'
        ]);
    }
}
