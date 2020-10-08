<?php

namespace App\Http\Controllers;

use App\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthorsController extends Controller
{

    public function index()
    {
        $query = Author::sortable();
        $nameQuery = '';
        $surnameQuery = '';

        if (isset($_GET['name'])) {
            $nameQuery = $_GET['name'];
            if (!preg_match('//u', $nameQuery)) {
                $nameQuery = iconv("cp1251","UTF-8", $nameQuery);
            }
            $query->where('name', 'LIKE', '%' . $nameQuery . '%');
        }

        if (isset($_GET['surname'])) {
            $surnameQuery = $_GET['surname'];
            if (!preg_match('//u', $surnameQuery)) {
                $surnameQuery = iconv("cp1251","UTF-8", $surnameQuery);
            }
            $query->where('surname', 'LIKE', '%' . $surnameQuery . '%');
        }

        $authors = $query->paginate(15);

        return view('authors.list', compact('authors', 'nameQuery', 'surnameQuery'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'surname' => 'required|min:3|max:255',
            'name' => 'required|max:255',
            'patronymic' => 'max:255',
        ]);

        $author = Author::updateOrCreate(['id' => $request->id], [
            'surname' => $request->surname,
            'name' => $request->name,
            'patronymic' => $request->patronymic
        ]);

        $message = $request->id ? 'Author Updated successfully' : 'Author Created successfully';

        return response()->json([
            'code'=>200,
            'message' => $message,
            'data' => $author
        ], 200);
    }

    public function show($id)
    {
        $author = Author::find($id);
        return response()->json($author);
    }

    public function destroy($id)
    {
        if (DB::table('author_book')->where('author_id', $id)->first()) {
            $status = 'danger';
            $message = 'You cannot delete this author as it is linked to the book';
        } else {
            Author::find($id)->delete();
            $status = 'success';
            $message = 'Author Deleted successfully';
        }

        return response()->json([
            'status' => $status,
            'message' => $message
        ]);
    }

}
