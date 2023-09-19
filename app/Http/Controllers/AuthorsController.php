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
use App\Models\Country;
use App\Models\Publication;
use App\Models\PublicationAuthor;
use App\Models\Type;
use PhpOffice\PhpWord\Element\Table;
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Settings;

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

    public function AboutAuthorGenerate(Request $req)
    {
        $author = Author::where('id', $req->id)->first();
        $fullname = $author->SerName . ' ' . $author->name . ' ' . $author->Patronic;
        $position = $author->Position !== 1 ?  Position::where('id', $author->Position)->first()->PositionName : null;
        $degree = $author->DegreeName !== 1 ? Degree::where('id', $author->Degree)->first()->DegreeName : null;
        $rank = $author->Rank !== 1 ? Ranks::where('id', $author->Rank)->first()->RankName : null;
        $templateProcessor = new TemplateProcessor('files/base/author_base.docx');
        $templateProcessor->setValue('author', $fullname);
        $templateProcessor->setValue('authorPlace', $position ? $position : '-');
        $templateProcessor->setValue('authorDegree', $degree ? $degree : '-');
        $templateProcessor->setValue('authorRank', $rank ? $rank : '-');

        $table = new Table(array('unit' =>  \PhpOffice\PhpWord\SimpleType\TblWidth::TWIP, 'orientation' => 'landscape'));
        $borderStyle = [
            'borderSize' => 6,
            'valign' => 'center'
        ];
        $text = [
            'name' => 'Arial',
            'size' => '10',
            'color' => '000000',
            'bold' => true,
        ];
        $textLight = [
            'name' => 'Arial',
            'size' => '10',
            'color' => '000000',
        ];
        $verticalCenter = ['spaceAfter' => 550, 'spaceBefore' => 550, 'align' => 'center'];
        $table->addRow();
        $table->addCell(500, $borderStyle)->addText('№ з/п', [
            ...$text,
            'italic' => false
        ], [...$verticalCenter]);
        $table->addCell(750, [
            ...$borderStyle,
            'textDirection' => \PhpOffice\PhpWord\Style\Cell::TEXT_DIR_BTLR,
        ])->addText('Тип публікації', [
            ...$text,
            'italic' => true,
        ], [
            'spaceAfter' => 200,
            'spaceBefore' => 200,
            'align' => 'center'
            // ...$verticalCenter
        ]);
        $table->addCell(2700, [
            ...$borderStyle,

        ])->addText('Співавтори (прізвище студента підкреслити)', $text,  ['spaceAfter' => 400, 'spaceBefore' => 375, 'align' => 'center']);
        $table->addCell(9000, [...$borderStyle, 'valign' => 'center',])->addText('Назва публікації', $text, [...$verticalCenter]);
        $table->addCell(11000,  [...$borderStyle, 'valign' => 'center',])->addText('Бібліографічні дані', $text, [...$verticalCenter]);
        $table->addCell(750, [
            ...$borderStyle,
            'textDirection' => \PhpOffice\PhpWord\Style\Cell::TEXT_DIR_BTLR,
        ])->addText('Місяць<w:br/> та рік видання', $text, [
            'spaceAfter' => 200,
            'spaceBefore' => 200,
            'align' => 'center'
        ]);
        $table->addCell(750, [
            ...$borderStyle,
            'textDirection' => \PhpOffice\PhpWord\Style\Cell::TEXT_DIR_BTLR,
        ])->addText('Друковані аркуші', $text, [
            'spaceAfter' => 200,
            'spaceBefore' => 200,
            'align' => 'center'
        ]);
        $table->addCell(750, [
            ...$borderStyle,
            'textDirection' => \PhpOffice\PhpWord\Style\Cell::TEXT_DIR_BTLR,
        ])->addText('Фахове видання', $text, [
            'spaceAfter' => 200,
            'spaceBefore' => 200,
            'align' => 'center'
        ]);
        $table->addCell(750, [
            ...$borderStyle,
            'textDirection' => \PhpOffice\PhpWord\Style\Cell::TEXT_DIR_BTLR,
        ])->addText('Спрямування публікації', $text, [
            'spaceAfter' => 200,
            'spaceBefore' => 200,
            'align' => 'center'
        ]);
        $table->addCell(750, [
            ...$borderStyle,
            'textDirection' => \PhpOffice\PhpWord\Style\Cell::TEXT_DIR_BTLR,
        ])->addText('Країна видання', $text, [
            'spaceAfter' => 200,
            'spaceBefore' => 200,
            'align' => 'center'
        ]);
        $table->addCell(750, [
            ...$borderStyle,
            'textDirection' => \PhpOffice\PhpWord\Style\Cell::TEXT_DIR_BTLR,
        ])->addText('ІSI/Scopus', $text, [
            'spaceAfter' => 200,
            'spaceBefore' => 200,
            'align' => 'center'
        ]);
        $table->addRow();
        $table->addCell(1, [...$borderStyle,])->addText('1', $textLight, ['align' => 'center']);
        $table->addCell(1, [...$borderStyle,])->addText('2', $textLight, ['align' => 'center']);
        $table->addCell(1, [...$borderStyle,])->addText('3', $textLight, ['align' => 'center']);
        $table->addCell(1, [...$borderStyle,])->addText('4', $textLight, ['align' => 'center']);
        $table->addCell(1, [...$borderStyle,])->addText('5', $textLight, ['align' => 'center']);
        $table->addCell(1, [...$borderStyle,])->addText('6', $textLight, ['align' => 'center']);
        $table->addCell(1, [...$borderStyle,])->addText('7', $textLight, ['align' => 'center']);
        $table->addCell(1, [...$borderStyle,])->addText('8', $textLight, ['align' => 'center']);
        $table->addCell(1, [...$borderStyle,])->addText('9', $textLight, ['align' => 'center']);
        $table->addCell(1, [...$borderStyle,])->addText('10', $textLight, ['align' => 'center']);
        $table->addCell(1, [...$borderStyle,])->addText('11', $textLight, ['align' => 'center']);


        $publications = Publication::select('publications.*')->join('publication_authors', 'publications.id', 'publication_authors.Publication')->where('Author', $req->id)->get();

        foreach ($publications as $key => $publication) {
            $table->addRow();
            $table->addCell(1, [...$borderStyle, 'valign' => 'center',])->addText(count($publications) - $key, $textLight, [
                'valign' => 'center',
                'align' => 'center'
            ]);
            $type = Type::where('id', $publication->Type)->first()->TypeShortName;
            $table->addCell(1, [...$borderStyle, 'valign' => 'center',])->addText($type, $textLight, [

                'align' => 'center'
            ]);
            $coAithors = PublicationAuthor::where('Publication', $publication->id)->get();

            $authorsCell = $table->addCell(1, [...$borderStyle,]);
            foreach ($coAithors as $author) {
                if ($author->Author !== (int) $req->id) {
                    $author = Author::where('id', $author->Author)->first();
                    $name = $author->SerName . ' ' . mb_str_split($author->Name)[0] . '.' . ($author->Patronic ?  ' ' . mb_str_split($author->Patronic)[0] . '.' : '');
                    $style = [
                        ...$textLight
                    ];

                    if ($author->Position === 2) {
                        $style = [
                            ...$textLight,
                            'underline' => 'single'
                        ];
                    }
                    $authorsCell->addText($name . ',', $style);
                }
            }

            $table->addCell(1, [...$borderStyle,])->addText($publication->Name, $textLight);
            $libData = '';
            $table->addCell(1, [...$borderStyle,])->addText($libData, $textLight);
            $date = date('m.Y', strtotime($publication->PublicationDate));
            $table->addCell(1, [...$borderStyle,])->addText($date, $textLight, ['align' => 'center']);
            $table->addCell(1, [...$borderStyle,])->addText($publication->UPP, $textLight, ['align' => 'center']);
            $table->addCell(1, [...$borderStyle,])->addText('-', $textLight, ['align' => 'center']);
            $table->addCell(1, [...$borderStyle,])->addText('-', $textLight, ['align' => 'center']);
            $country = Country::where('id', $publication->Country)->first()->CountryShortName;
            $table->addCell(1, [...$borderStyle,])->addText($country, $textLight, ['align' => 'center']);
            $scopus = '-';
            $table->addCell(1, [...$borderStyle,])->addText($scopus, $textLight, ['align' => 'center']);
        }
        $filename = 'author_' . $req->id . "_all_publications";

        $templateProcessor->setComplexBlock('{table}', $table);

        $templateProcessor->saveAs('./files/' . $filename . '.docx', 'Word2007');

        return redirect()->to('/files/' . $filename . '.docx');
    }
}
