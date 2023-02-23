<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Type;
use App\Models\Languages;
use App\Models\Publisher;
use App\Models\Author;

use App\Models\Publication;
use App\Models\PublicationAuthor;


class PublicationsController extends Controller
{
    public function AddPublication(Request $req){
        try {
            $newPubl = $req->obj;
            $publication = new Publication();
            $publication->PublicationDate = $newPubl['date'];
            $publication->Name = $newPubl['name'];
            $publication->Type = $newPubl['type'];
            $publication->StartPage = $newPubl['startPage'];
            $publication->EndPage = $newPubl['lastPage'];
            $publication->UPP = $newPubl['UPP'];
            $publication->Language = $newPubl['lang'];
            $publication->Publisher = $newPubl['publisher'];
            $publication->PublicationDate = $newPubl['date'];
            $newPubl['url'] !== null && $publication->DOI = $newPubl['url'];

            $newPubl['supervisor'] !== 0 && $publication->Supervisor = $newPubl['supervisor'];
            $publication->save();

            for($i = 0; $i < count($newPubl['authors']); $i++){

                $publicationAuthor = new PublicationAuthor();
                $publicationAuthor->Publication = $publication->id;
                $publicationAuthor->Author = $newPubl['authors'][$i]['id'];
                $publicationAuthor->save();
            }

            return response()->json([
                'success' => true,
                'message' => 'Publication Added Successfully',
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }

    }

    public function GetPublicationsSetup(){
        try {
            $data = [
                'types' => Type::get(['id', 'TypeShortName']),
                'languages' => Languages::get(['id', 'LanguageShortName']),
                'publishers' => Publisher::get(['id', 'PublisherName']),
                'authors' => Author::all()
            ];
            return response()->json([
                'success' => true,
                'message' => 'Setup founded successfully',
                'data' => $data,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }
}
