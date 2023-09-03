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
            'Orcid' => '0000000158055838',
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
            'Orcid' => '0000000245399655',
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
            'Orcid' => '0000000243300359',
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
            'Orcid' => '0000000239455032',
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
            'Orcid' => '0000000345455247',
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
            'Orcid' => '0000000268118115',
            'SerName' => 'Істоміна',
            'Name' => 'Наталія',
            'Patronic' => 'Миколаївна',
            'Position' => '5',
            'Department' => '2',
            'Specialty' => '1',
            'Degree' => '5',
            'Rank' => '1',
            'PlanningStatus' => true,
        ],
        [
            //7
            'Orcid' => '0000000251781332',
            'SerName' => 'Коваль',
            'Name' => 'Світлана',
            'Patronic' => 'Станіславівна',
            'Position' => '5',
            'Department' => '2',
            'Specialty' => '1',
            'Degree' => '5',
            'Rank' => '2',
            'PlanningStatus' => true,
        ],
        [
            //8
            'Orcid' => '0000000172082680',
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
            'Orcid' => '0000000159301957',
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
            //11
            'Orcid' => '0000000250011280',
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
            'Orcid' => '0000000219594684',
            'SerName' => 'Луценко',
            'Name' => 'Ігор',
            'Patronic' => 'Анатолійович',
            'Position' => '6',
            'Department' => '2',
            'Specialty' => '1',
            'Degree' => '3',
            'Rank' => '3',
            'PlanningStatus' => true,
        ],[
            //13
            'Orcid' => '0000000268212072',
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
            'Orcid' => '0000000304950604',
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
            'Orcid' => '0000000214006177',
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
            'Orcid' => '000000024570711X',
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
            'Orcid' => '0000000299311591',
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
            'Orcid' => '000000033251368X',
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
            'Orcid' => '000000021136653X',
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
            'Orcid' => '0000000191786202',
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
            'Orcid' => '0000000330098611',
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
