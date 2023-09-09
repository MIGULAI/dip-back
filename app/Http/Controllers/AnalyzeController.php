<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Plan;
use App\Models\Publication;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyzeController extends Controller
{
    public function GetAuthorsOfDepartmentCount(): array
    {
        $departmentId = 2;
        $count = Author::where('Department', $departmentId)->where('PlanningStatus', true)->count();
        return [
            'success' => true,
            'message' => ['Кількість авторів за кафедрою'],
            'count' => $count
        ];
    }

    private function getLastYears(): array
    {
        $yearNow =  date('Y');
        if (date('Y-m-d') <= date('Y') . '-08-31') $yearNow -= 1;
        $years = [];
        for ($i = 0; $i < 5; $i++) {
            array_push($years, $yearNow - $i);
        }
        return $years;
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
    public function GetStudentCount(): array
    {
        $departmentId = 2;
        $authorPosition = 2;

        $years = $this->getLastYears();
        $studentsPerYearCount = [];
        foreach ($years as $year) {
            $dateFrom = $year . '-09-01';
            $dateTo = $year + 1 . '-08-31';
            $publsDepAuthorsIsStudentsPerYearCount =
                DB::table('publication_authors')
                ->select(DB::raw('count(*)'))
                ->join('authors', 'authors.id', '=', 'publication_authors.Author')
                ->join('publications', 'publications.id', '=', 'publication_authors.Publication')
                ->where('authors.Department', $departmentId)
                ->where('authors.Position', $authorPosition)
                ->whereBetween('publications.PublicationDate', [$dateFrom, $dateTo])
                ->groupBy('publication_authors.Publication')
                ->get();
            $studentsPerYearCount[$year] = count($publsDepAuthorsIsStudentsPerYearCount);
        }
        return [
            'success' => true,
            'data' => $studentsPerYearCount
        ];
    }
    public function GetCountByYearsAndTypes(): array
    {
        $departmentId = 2;
        $years = $this->getLastYears();
        $types = Type::get(['id', 'TypeShortName as typeName']);
        $statistic = [];
        foreach ($types as $type) {
            $publs = [];
            foreach ($years as $year) {
                $dateFrom = $year . '-09-01';
                $dateTo = $year + 1 . '-08-31';
                $typeid = $type->id;
                $typeByYearPubls = DB::table('publication_authors')
                    ->select(DB::raw('count(*)'))
                    ->join('authors', 'authors.id', '=', 'publication_authors.Author')
                    ->join('publications', 'publications.id', '=', 'publication_authors.Publication')
                    ->where('publications.Type', $typeid)
                    ->where('authors.Department', $departmentId)
                    ->whereBetween('publications.PublicationDate', [$dateFrom, $dateTo])
                    ->groupBy('publication_authors.Publication')
                    ->get();
                $publs[$year] = count($typeByYearPubls);
            }
            $statistic[$type->typeName] = $publs;
        }
        return [
            'success' => true,
            'data' => $statistic
        ];
    }
}
