<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Publication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyzeController extends Controller
{
    public function GetAuthorsOfDepartmentCount()
    {
        $departmentId = 2;
        $count = Author::where('Department', $departmentId)->where('PlanningStatus', true)->count();
        return [
            'success' => true,
            'message' => ['Кількість авторів за кафедрою'],
            'count' => $count
        ];
    }

    public function GetBasicDepStats(): array
    {
        $departmentId = 2;
        $authorPosition = 2;
        $authorsCount = Author::where('Department', $departmentId)->where('PlanningStatus', true)->count();
        $publsDepAuthorsCount = DB::table('authors')->select(DB::raw('count(*) as count'))->join('publication_authors', 'publication_authors.Author', '=', 'authors.id')
            ->where('authors.Department', $departmentId)
            ->where('authors.PlanningStatus', true)
            ->groupBy('publication_authors.Publication')
            ->get();
        $publsDepAuthorsIsStudentsCount = DB::table('authors')->select(DB::raw('count(*) as count'))->join('publication_authors', 'publication_authors.Author', '=', 'authors.id')
            ->where('authors.Department', $departmentId)
            ->where('authors.Position', $authorPosition)
            ->groupBy('publication_authors.Publication')
            ->get();

        return [
            'success' => true,
            'message' => ['Базова статистика за кафедрою'],
            'data' => [
                'countAuthors' => $authorsCount,
                'publs' => count($publsDepAuthorsCount),
                'publsWithStudents' => count($publsDepAuthorsIsStudentsCount)

            ]
        ];
    }
}
