<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('authors')->insert([[
            //1
            'Orcid' => Str::random(16),
            'SerName' => 'Бельська',
            'Name' => 'Вікторія',
            'Patronic' => 'Юріївна',
            'Position' => '4',
            'Department' => '2',
            'Specialty' => '1',
            'Degree' => '1',
            'Rank' => '1',
            'PlanningStatus' => true,
        ],[
            //2
            'Orcid' => Str::random(16),
            'SerName' => 'Бурдільна',
            'Name' => 'Євгенія',
            'Patronic' => 'Володимирівна',
            'Position' => '4',
            'Department' => '2',
            'Specialty' => '1',
            'Degree' => '1',
            'Rank' => '1',
            'PlanningStatus' => true,
        ],[
            //3
            'Orcid' => Str::random(16),
            'SerName' => 'Васильєв',
            'Name' => 'Денис',
            'Patronic' => 'Олегович',
            'Position' => '4',
            'Department' => '2',
            'Specialty' => '1',
            'Degree' => '1',
            'Rank' => '1',
            'PlanningStatus' => true,
        ],[
            //4
            'Orcid' => Str::random(16),
            'SerName' => 'Горлова',
            'Name' => 'Тетяна',
            'Patronic' => 'Валентинівна',
            'Position' => '4',
            'Department' => '2',
            'Specialty' => '1',
            'Degree' => '1',
            'Rank' => '1',
            'PlanningStatus' => true,
        ],[
            //5
            'Orcid' => Str::random(16),
            'SerName' => 'Дернова',
            'Name' => 'Майя',
            'Patronic' => 'Григорівна',
            'Position' => '6',
            'Department' => '2',
            'Specialty' => '1',
            'Degree' => '2',
            'Rank' => '2',
            'PlanningStatus' => true,
        ],[
            //6
            'Orcid' => Str::random(16),
            'SerName' => 'Істоміна',
            'Name' => 'Наталія',
            'Patronic' => 'Миколаївна',
            'Position' => '5',
            'Department' => '2',
            'Specialty' => '1',
            'Degree' => '5',
            'Rank' => '1',
            'PlanningStatus' => true,
        ],[
            //7
            'Orcid' => Str::random(16),
            'SerName' => 'Коваль',
            'Name' => 'Світлана',
            'Patronic' => 'Станіславівна',
            'Position' => '5',
            'Department' => '2',
            'Specialty' => '1',
            'Degree' => '5',
            'Rank' => '2',
            'PlanningStatus' => true,
        ],[
            //8
            'Orcid' => Str::random(16),
            'SerName' => 'Когдась',
            'Name' => 'Максим',
            'Patronic' => 'Григорович',
            'Position' => '5',
            'Department' => '2',
            'Specialty' => '1',
            'Degree' => '5',
            'Rank' => '2',
            'PlanningStatus' => true,
        ],[
            //9
            'Orcid' => Str::random(16),
            'SerName' => 'Конох',
            'Name' => 'Ігор',
            'Patronic' => 'Сергійович',
            'Position' => '6',
            'Department' => '2',
            'Specialty' => '1',
            'Degree' => '3',
            'Rank' => '2',
            'PlanningStatus' => true,
        ],[
            //10
            'Orcid' => Str::random(16),
            'SerName' => 'Король',
            'Name' => 'Катерина',
            'Patronic' => 'Сергіївна',
            'Position' => '3',
            'Department' => '2',
            'Specialty' => '1',
            'Degree' => '1',
            'Rank' => '1',
            'PlanningStatus' => true,
        ],[
            //11
            'Orcid' => Str::random(16),
            'SerName' => 'Ломонос',
            'Name' => 'Андрій',
            'Patronic' => 'Іванович',
            'Position' => '5',
            'Department' => '2',
            'Specialty' => '1',
            'Degree' => '5',
            'Rank' => '2',
            'PlanningStatus' => true,
        ],[
            //12
            'Orcid' => Str::random(16),
            'SerName' => 'Луценко',
            'Name' => 'І',
            'Patronic' => 'А',
            'Position' => '6',
            'Department' => '2',
            'Specialty' => '1',
            'Degree' => '3',
            'Rank' => '3',
            'PlanningStatus' => true,
        ],[
            //13
            'Orcid' => Str::random(16),
            'SerName' => 'Найда',
            'Name' => 'Віталій',
            'Patronic' => 'Володимирович',
            'Position' => '4',
            'Department' => '2',
            'Specialty' => '1',
            'Degree' => '5',
            'Rank' => '1',
            'PlanningStatus' => true,
        ],[
            //14
            'Orcid' => Str::random(16),
            'SerName' => 'Нікітіна',
            'Name' => 'Альона',
            'Patronic' => 'Вікторівна',
            'Position' => '5',
            'Department' => '2',
            'Specialty' => '1',
            'Degree' => '5',
            'Rank' => '1',
            'PlanningStatus' => true,
        ],[
            //15
            'Orcid' => Str::random(16),
            'SerName' => 'Оксанич',
            'Name' => 'Анатолій',
            'Patronic' => 'Петрович',
            'Position' => '6',
            'Department' => '2',
            'Specialty' => '1',
            'Degree' => '3',
            'Rank' => '3',
            'PlanningStatus' => true,
        ],[
            //16
            'Orcid' => Str::random(16),
            'SerName' => 'Оксанич',
            'Name' => 'Ірина',
            'Patronic' => 'Григорівна',
            'Position' => '6',
            'Department' => '2',
            'Specialty' => '1',
            'Degree' => '3',
            'Rank' => '2',
            'PlanningStatus' => true,
        ],[
            //17
            'Orcid' => Str::random(16),
            'SerName' => 'Притчин',
            'Name' => 'Сергій',
            'Patronic' => 'Емільович',
            'Position' => '6',
            'Department' => '2',
            'Specialty' => '1',
            'Degree' => '3',
            'Rank' => '3',
            'PlanningStatus' => true,
        ],[
            //18
            'Orcid' => Str::random(16),
            'SerName' => 'Палагін',
            'Name' => 'Віктор',
            'Patronic' => 'Андрійович',
            'Position' => '6',
            'Department' => '2',
            'Specialty' => '1',
            'Degree' => '3',
            'Rank' => '3',
            'PlanningStatus' => true,
        ],[
            //19
            'Orcid' => Str::random(16),
            'SerName' => 'Рилова',
            'Name' => 'Наталя',
            'Patronic' => 'Вікторівна',
            'Position' => '4',
            'Department' => '2',
            'Specialty' => '1',
            'Degree' => '5',
            'Rank' => '1',
            'PlanningStatus' => true,
        ],[
            //20
            'Orcid' => Str::random(16),
            'SerName' => 'Самойлов',
            'Name' => 'Андрій',
            'Patronic' => 'Миколайович',
            'Position' => '4',
            'Department' => '2',
            'Specialty' => '1',
            'Degree' => '1',
            'Rank' => '1',
            'PlanningStatus' => true,
        ],[
            //20
            'Orcid' => Str::random(16),
            'SerName' => 'Шевченко',
            'Name' => 'Ігор',
            'Patronic' => 'Васильович',
            'Position' => '6',
            'Department' => '2',
            'Specialty' => '1',
            'Degree' => '3',
            'Rank' => '3',
            'PlanningStatus' => true,
        ],]);
    }
}
