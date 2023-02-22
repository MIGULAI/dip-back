<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Author;


class AuthorsController extends Controller
{
    public function GetAutors(){
        try {
            $autors = Author::all();

            return response()->json([
                'success' => true,
                'message' => $autors->toJson()
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function AddAutor(Request $req)
    {
        try {
            $newAutor = $req->obj;
            $author = new Autor();
            $author->SerName = $newAuthor['sername'];
            $author->Name = $newAuthor['name'];
            $author->Patronic = $newAuthor['partonic'];
            $author->Department = $newAuthor['department'];
            $author->Position = $newAuthor['place'];
            $author->Group = $newAuthor['group'];
            $author->Degree = $newAuthor['degree'];
            $author->Rank = $newAuthor['rank'];
            return response()->json([
                'success' => true,
                'message' => 'Author successfully added'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }
}
