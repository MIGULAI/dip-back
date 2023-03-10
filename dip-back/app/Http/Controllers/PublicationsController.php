<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Type;
use App\Models\Languages;
use App\Models\Publisher;
use App\Models\Author;

use App\Models\Publication;
use App\Models\PublicationAuthor;

use App\Http\Controllers\AuthorsController;
use App\Http\Controllers\PublisherController;


class PublicationsController extends Controller
{

    public static function CreatePublication($newPubl)
    {
        try {
            $publication = new Publication();
            $publication->PublicationDate = $newPubl['date'];
            $publication->Name = $newPubl['name'];
            $publication->Type = $newPubl['type'];
            $publication->StartPage = $newPubl['startPage'];
            $publication->EndPage = $newPubl['lastPage'];
            $publication->UPP = $newPubl['UPP'];
            $publication->Language = $newPubl['lang'];
            $publication->Publisher = $newPubl['publisher'];
            $publication->PublicationDate = date($newPubl['date']);
            $newPubl['url'] !== null && $publication->DOI = $newPubl['url'];

            $newPubl['supervisor'] !== 0 && $publication->Supervisor = $newPubl['supervisor'];
            $publication->save();

            for ($i = 0; $i < count($newPubl['authors']); $i++) {

                $publicationAuthor = new PublicationAuthor();
                $publicationAuthor->Publication = $publication->id;
                $publicationAuthor->Author = $newPubl['authors'][$i]['id'];
                $publicationAuthor->save();
            }
            return [true, 'Publication Added Successfull'];
        } catch (\Throwable $th) {
            return [false, $th->getMessage()];
        }
    }

    public function AddPublication(Request $req)
    {
        try {
            $newPubl = $req->obj;
            $status = $this::CreatePublication($newPubl);
            if ($status[0]) {
                return response()->json([
                    'success' => true,
                    'message' => $status[1],
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => $status[1],
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function GetPublicationsSetup()
    {
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

    public function JSONToPublications(Request $req)
    {
        try {
            $publications = json_decode($req->file('body')->get())->valid;
            $authors = [];
            $counter = 0;
            foreach ($publications as $publication) {
                $pubCheck = Publication::where('Name', $publication->name)->first();
                if (!$pubCheck) {
                    $publAuthors = [];
                    $author = explode(' ', $publication->mainAutor);
                    $mainAuthor = Author::where('SerName', $author[0])
                        ->where('Name', $author[1])
                        ->where('Patronic', $author[2])->first();
                    if(!$mainAuthor){
                        $authorController = new AuthorsController();

                        $authorArray = [
                            'sername' => $author[0],
                            'name' => $author[1],
                            'partonic' => $author[2],
                        ];
                        $arr = $authorController::NewAuthorCreate($authorArray);
                        $mainAuthor = $arr[1];
                    }else{
                        $mainAuthor = $mainAuthor->id;
                    }
                    array_push($publAuthors, ['id' => $mainAuthor]);
                    foreach ($publication->autors as $subAuthor) {


                        $sub = Author::where('SerName', 'LIKE', $subAuthor->sername)
                            ->where('Name', 'LIKE', $subAuthor->name . '%')
                            ->where('Patronic', 'LIKE', $subAuthor->patronic . '%')->first();
                        if (!$sub) {
                            $authorController = new AuthorsController();
                            $authorArray = [
                                'sername' => $subAuthor->sername,
                                'name' => $subAuthor->name,
                                'partonic' => $subAuthor->patronic,
                            ];
                            $id = $authorController::NewAuthorCreate($authorArray);
                            if ($id[0] === true) {
                                array_push($publAuthors, ['id' => $id[1]]);
                            } else {
                                return response()->json([
                                    'success' => false,
                                    'message' => $id
                                ]);
                            }
                        }
                    }

                    $id = Publisher::where('PublisherName', $publication->libData)->first();

                    if (!$id) {
                        $publisherController = new PublisherController();
                        $publ = $publisherController::CreatePublisher($publication->libData);
                        if ($publ[0]) {
                            $id = $publ[1];
                        } else {
                            return response()->json([
                                'success' => false,
                                'message' => $publ[1]
                            ]);
                        }
                    }else{
                        $id = $id->id;
                    }

                    $newPubl = [
                        'name' => $publication->name,
                        'authors' => $publAuthors,
                        'type' => $publication->type,
                        'startPage' => 0,
                        'lastPage' => 0,
                        'UPP' => $publication->DA,
                        'lang' => 1,
                        'date' => $publication->pubDate,
                        'url' => null,
                        'supervisor' => 0,
                        'publisher' => $id
                    ];
                    $res = $this::CreatePublication($newPubl);
                    if($res[0]){
                        $counter += 1;
                    }else{
                        return response()->json([
                            'success' => false,
                            'message' => $res[1]
                        ]);
                    }
                }
            }
            return response()->json([
                'success' => true,
                'message' => 'file was found',
                'data' => [
                    'counter' => $counter,

                ]
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function PublByAuthorID(Request $req){
        try {
            $publs = Publication::join('publication_authors', 'publications.id', 'publication_authors.Publication')->where('Author', $req->id)->get();
            foreach($publs as $publ){
                $publ->TypeName = Type::where('id', $publ->Type)->first()->TypeName;
                $publ->LanguageName = Languages::where('id', $publ->Language)->first()->LanguageName;
            }
            return response()->json([
                'success' => true,
                'message' => 'Publications of author by id',
                'data' => [
                    'publs' => $publs
                ]
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }
}
