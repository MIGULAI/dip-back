<?php

namespace App\Http\Controllers;

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
                'authors' => Author::join('departments', 'departments.id', 'authors.Specialty')    
                                    ->join('organizations', 'organizations.id', 'departments.idOrganization')
                                    ->join('positions', 'positions.id', 'authors.Position')
                                    ->join('specialties', 'specialties.id', 'authors.Specialty')
                                    ->join('degrees', 'degrees.id', 'authors.Degree')
                                    ->join('ranks', 'ranks.id', 'authors.Rank')
                                    ->get()
            ];
            return response()->json([
                'success' => true,
                'message' => 'Authors was found',
                'data' => $data
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
    public static function  NewAuthorCreate($newAuthor){
        try {
            $author = new Author();
            $author->SerName = $newAuthor['sername'];
            $author->Name = $newAuthor['name'];
            $author->Patronic = $newAuthor['partonic'];
            isset($newAuthor['department']) && $author->Department = $newAuthor['department'];
            isset($newAuthor['place']) && $author->Position = $newAuthor['place'];
            isset($newAuthor['group']) && $author->Specialty = $newAuthor['group'];
            isset($newAuthor['degree']) && $author->Degree = $newAuthor['degree'];
            isset($newAuthor['rank']) && $author->Rank = $newAuthor['rank'];
            $author->save();
            return [true, $author->id];
        } catch (\Throwable $th) {
            return [false, $th->getMessage()];
        }

    }

    public function AddAuthor(Request $req)
    {
        try {
            $newAuthor = $req->obj;
            $status = $this::NewAuthorCreate($newAuthor);
            if($status){
                return response()->json([
                    'success' => true,
                    'message' => 'Author successfully added'
                ]);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => $status
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }
}
