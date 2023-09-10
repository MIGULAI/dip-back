<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthorRequest;
use Illuminate\Http\Request;

use App\Models\Specialty;
use App\Models\Organization;
use App\Models\Department;
use App\Models\Position;
use App\Models\Degree;
use App\Models\Ranks;
use App\Models\Author;
use Mockery\Undefined;

class AuthorsController extends Controller
{
    public function GetAuthors()
    {
        try {

            $data = [
                'authors' => Author::select('authors.*')
                    ->join('departments', 'departments.id', 'authors.Specialty')
                    ->join('organizations', 'organizations.id', 'departments.idOrganization')
                    ->join('positions', 'positions.id', 'authors.Position')
                    ->join('specialties', 'specialties.id', 'authors.Specialty')
                    ->join('degrees', 'degrees.id', 'authors.Degree')
                    ->join('ranks', 'ranks.id', 'authors.Rank')
                    ->get()
            ];
            return response()->json([
                'success' => true,
                'message' => ['Authors was found'],
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => [$th->getMessage()]
            ]);
        }
    }
    public function GetPlaningAuthors()
    {
        try {

            $data = [
                'authors' => Author::select('authors.*')
                    ->join('departments', 'departments.id', 'authors.Specialty')
                    ->join('organizations', 'organizations.id', 'departments.idOrganization')
                    ->join('positions', 'positions.id', 'authors.Position')
                    ->join('specialties', 'specialties.id', 'authors.Specialty')
                    ->join('degrees', 'degrees.id', 'authors.Degree')
                    ->join('ranks', 'ranks.id', 'authors.Rank')
                    ->where('authors.PlanningStatus', true)
                    ->where('authors.Department', 2)
                    ->get()
            ];
            return response()->json([
                'success' => true,
                'message' => ['Authors was found'],
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => [$th->getMessage()]
            ]);
        }
    }
    public function GetAuthorsFull()
    {
        try {

            $data = [
                //'authors' => Author::select('*')
                'authors' => Author::select('authors.*', 'positions.PositionName', 'degrees.DegreeName', 'ranks.RankName')
                    ->join('departments', 'departments.id', 'authors.Specialty')
                    ->join('organizations', 'organizations.id', 'departments.idOrganization')
                    ->join('positions', 'positions.id', 'authors.Position')
                    ->join('specialties', 'specialties.id', 'authors.Specialty')
                    ->join('degrees', 'degrees.id', 'authors.Degree')
                    ->join('ranks', 'ranks.id', 'authors.Rank')
                    ->get()
            ];
            return response()->json([
                'success' => true,
                'message' => ['Authors was found'],
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => [$th->getMessage()]
            ]);
        }
    }
    public function PutAuthor(AuthorRequest $req)
    {
        try {
            // return $req;
            $author = Author::where('id', $req->author['id'])->first();
            $author->Degree = $req->author['degree'];
            $author->Department = $req->author['department'];
            $author->Name = $req->author['firstName'];
            $author->NameEng = $req->author['firstNameEng'];
            $author->Orcid = $req->author['orcid'];
            $author->Patronic = $req->author['patronicName'];
            $author->PatronicEng = $req->author['patronicEng'];
            // $author->PlanningStatus = $req->author['PlanningStatus'];
            $author->Position = $req->author['position'];
            $author->Rank = $req->author['rank'];
            // $author->Scopus = $req->author['Scopus'];
            $author->SerName = $req->author['serName'];
            $author->SerNameEng = $req->author['serNameEng'];
            $author->Specialty = $req->author['specialty'];
            if ($author->Department === 2) {
                $author->StartDate = $req->author['startDate'];
            }
            if ($author->SerName && $author->SerNameEng && $author->Name && $author->NameEng && $author->Orcid) {
                $author->save();
                return response()->json([
                    'success' => true,
                    'message' => ['Author was updated'],
                    'data' => [
                        "author" => $author
                    ]
                ]);
            }
            return response()->json([
                'success' => false,
                'message' => ['Author wasn`t updated'],
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => [$th->getMessage()]
            ]);
        }
    }

    public function GetAuthor(Request $req)
    {
        try {

            /*$data = [
                'authors' => Author::select('authors.*')
                                    ->join('departments', 'departments.id', 'authors.Specialty')    
                                    ->join('organizations', 'organizations.id', 'departments.idOrganization')
                                    ->join('positions', 'positions.id', 'authors.Position')
                                    ->join('specialties', 'specialties.id', 'authors.Specialty')
                                    ->join('degrees', 'degrees.id', 'authors.Degree')
                                    ->join('ranks', 'ranks.id', 'authors.Rank')
                                    ->get()
            ];*/
            return response()->json([
                'success' => true,
                'message' => 'Author was found',
                'data' => [
                    "author" => Author::where('id', $req->id)->first()
                ]
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function GetAuthorsSetup()
    {
        try {
            $data = [
                'specialties' => Specialty::get(['id', 'SpecialtyName']),
                'organizations' => Organization::get(['id', 'OrganizationName']),
                'departments' => Department::get(['id', 'DepartmanName', 'idOrganization']),
                'positions' => Position::get(['id', 'PositionName']),
                'degrees' => Degree::get(['id', 'DegreeName']),
                'ranks' => Ranks::get(['id', 'RankName']),
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
    public static function  NewAuthorCreate($newAuthor)
    {
        try {
            $author = new Author();
            $author->SerName = $newAuthor['serName'];
            $author->SerNameEng = $newAuthor['serNameEng'];
            $author->Name = $newAuthor['firstName'];
            $author->NameEng = $newAuthor['firstNameEng'];
            $author->Patronic = $newAuthor['patronicName'];
            $author->PatronicEng = $newAuthor['patronicEng'];
            $author->Orcid = $newAuthor['orcid'];
            isset($newAuthor['department']) && $author->Department = $newAuthor['department'];
            isset($newAuthor['place']) && $author->Position = $newAuthor['place'];
            isset($newAuthor['group']) && $author->Specialty = $newAuthor['group'];
            isset($newAuthor['degree']) && $author->Degree = $newAuthor['degree'];
            isset($newAuthor['rank']) && $author->Rank = $newAuthor['rank'];
            isset($newAuthor['startDate']) && $author->StartDate = $newAuthor['startDate'];
            if ($author->SerName && $author->SerNameEng && $author->Name && $author->NameEng && $author->Orcid) {
                $author->save();
                return [true, $author->id];
            }
            return false;
        } catch (\Throwable $th) {
            return [false, $th->getMessage()];
        }
    }

    public function AddAuthor(Request $req)
    {
        try {
            $newAuthor = $req->obj;

            $status = $this::NewAuthorCreate($newAuthor);
            if ($status) {
                return response()->json([
                    'success' => true,
                    'message' => ['Author successfully added']
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => [$status]
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => [$th->getMessage()]
            ]);
        }
    }
}
