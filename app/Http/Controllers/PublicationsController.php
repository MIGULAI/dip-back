<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Type;
use App\Models\Languages;
use App\Models\Publisher;
use App\Models\Author;

use App\Models\Publication;
use App\Models\PublicationAuthor;
use App\Models\GlobalSetup;


use App\Http\Controllers\AuthorsController;
use App\Http\Controllers\PublisherController;
use App\Http\Requests\PublicationRequest;
use App\Models\Plan;
use App\Models\PublicationPlan;

class PublicationsController extends Controller
{

    public function GetAuthors(Request $req)
    {
        return [
            'success' => true,
            'data' => PublicationAuthor::select('Author as id')->where('Publication', $req->id)->get()
        ];
    }

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
            $publication->PublicationNumber = $newPubl['issue_numb'];
            $newPubl['url'] !== null && $publication->DOI = $newPubl['url'];

            $newPubl['supervisor'] !== 0 && $publication->Supervisor = $newPubl['supervisor'];
            $publication->save();

            for ($i = 0; $i < count($newPubl['authors']); $i++) {
                if ($newPubl['authors'][$i] !== null) {
                    $publicationAuthor = new PublicationAuthor();

                    $publicationAuthor->Publication = $publication->id;
                    $publicationAuthor->Author = $newPubl['authors'][$i]['id'];

                    $publicationAuthor->save();
                    
                    $year = date('Y', strtotime($newPubl['date']));
                    $controlDate = $year . '-09-01';
                    if (strtotime($newPubl['date']) < strtotime($controlDate)) {
                        $year -= 1;
                    }
                    $plan = Plan::where('AuthorId', $newPubl['authors'][$i])->where('Year', $year)->first();
                    $author = Author::where('id', $newPubl['authors'][$i])->first();
                    if ($author && $plan) {
                        $newPlanToPubl = new PublicationPlan();

                        $newPlanToPubl->Publication = $publication->id;
                        $newPlanToPubl->Plan = $plan->id;

                        $newPlanToPubl->save(); 
                    }
                }
            }
            return [true, ['Publication Added Successfull']];
        } catch (\Throwable $th) {
            return [false, [$th->getMessage()]];
        }
    }

    public function AddPublication(PublicationRequest $req)
    {
        try {
            $newPubl = $req;
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

    public function GetAllPublications()
    {
        try {
            return response()->json([
                'success' => true,
                'message' => 'Publications founded successfully',
                'data' => [
                    'publications' => Publication::all()
                ],
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function GetPublicationById(Request $req)
    {
        try {
            return response()->json([
                'success' => true,
                'message' => 'Publication founded successfully',
                'data' => [
                    'publication' => Publication::where('id', $req->id)->first(),
                    'authors' => PublicationAuthor::where('Publication', $req->id)->get()->toArray()
                ],
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function PutPublication(PublicationRequest $req)
    {
        try {
            // return GlobalSetup::where('SetupName', 'authorsPublCount')->first()->SetupValue;
            $authors =  $req->authors;
            // return $req->authors'];
            if (intval(count($authors)) !== intval(GlobalSetup::where('SetupName', 'authorsPublCount')->first()->SetupValue)) {
                return response()->json([
                    'success' => "false",
                    'message' => "Wrong authors count"
                ]);
            }
            $authorsList = []; // $req->authors;
            for ($i = 0; $i < count($authors); $i++) {
                if ($authors[$i] !== null) {
                    array_push($authorsList, $authors[$i]);
                }
            }
            // foreach ($authorsList as $author) {
            //     $pa = new PublicationAuthor();
            //     $pa->Publication = $req->id;
            //     $pa->Author = $author['id'];
            //     $pa->save();
            // }
            $publication = Publication::where('id', $req->id)->first();
            $publication->Name = $req->name;
            $publication->EndPage = $req->lastPage;
            $publication->StartPage = $req->startPage;
            $publication->Supervisor = $req->supervisor;
            $publication->Type = $req->type;
            $publication->UPP = $req->UPP;
            $publication->Publisher = $req->publisher;
            $publication->PublicationNumber = $req->issue_numb;
            if ($req->date !== null) {
                $publication->PublicationDate = $req->date;
            }
            $publication->Language = $req->lang;
            // $publication->Country = $req->Country'];
            $publication->DOI = $req->url;
            $publication->save();
            PublicationAuthor::where('Publication', $req->id)->delete();
            PublicationPlan::where('Publication',$req->id)->delete();
            $authors = $req->authors;
            if ($authors) {
                for ($i = 0; $i < count($authors); $i++) {
                    if ($authors[$i] !== null) {
                        $publicationAuthor = new PublicationAuthor();

                        $publicationAuthor->Publication = $publication->id;
                        $publicationAuthor->Author = $authors[$i]['id'];

                        $publicationAuthor->save();

                        $year = date('Y', strtotime($req->date));
                        $controlDate = $year . '-09-01';
                        if (strtotime($req->date) < strtotime($controlDate)) {
                            $year -= 1;
                        }
                        $plan = Plan::where('AuthorId', $authors[$i])->where('Year', $year)->first();
                        $author = Author::where('id', $authors[$i])->first();
                        if ($author && $plan) {
                            $newPlanToPubl = new PublicationPlan();
    
                            $newPlanToPubl->Publication = $publication->id;
                            $newPlanToPubl->Plan = $plan->id;
    
                            $newPlanToPubl->save(); 
                        }
                    }
                }
            }
            //return $authorsList;
            return response()->json([
                'success' => true,
                'message' => 'Publication updated successfully',
                'data' => [
                    //  'publication' => Publication::where('id', $req->id)->first(),
                    //  'authors' => PublicationAuthor::where('Publication', $req->id)->get()->toArray()
                ],
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
                    if (!$mainAuthor) {
                        $authorController = new AuthorsController();

                        $authorArray = [
                            'sername' => $author[0],
                            'name' => $author[1],
                            'partonic' => $author[2],
                        ];
                        $arr = $authorController::NewAuthorCreate($authorArray);
                        $mainAuthor = $arr[1];
                    } else {
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
                        //Метод було перероблено під створення видавця через api
                        //$publ = $publisherController::CreatePublisher($publication->libData);
                        // if ($publ[0]) {
                        //     $id = $publ[1];
                        // } else {
                        return response()->json([
                            'success' => false,
                            // 'message' => $publ[1]
                        ]);
                        // }
                    } else {
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
                    if ($res[0]) {
                        $counter += 1;
                    } else {
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

    public function PublByAuthorID(Request $req)
    {
        try {
            $publs = Publication::join('publication_authors', 'publications.id', 'publication_authors.Publication')->where('Author', $req->id)->get();
            foreach ($publs as $publ) {
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
