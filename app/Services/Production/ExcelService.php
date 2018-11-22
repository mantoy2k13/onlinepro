<?php
namespace App\Services\Production;

use App\Services\ExcelServiceInterface;

class ExcelService extends BaseService implements ExcelServiceInterface
{
    public function export($datas, $fileName, $format = 'xlsx')
    {
        \Excel::create($fileName, function ($excel) use ($datas) {
            $excel->setTitle($datas['title']);
            $excel->setCreator('Admin');
            $excel->setCompany(config('site.name', ''));
            $excel->setDescription('Time Sheet');
            $excel->sheet('Sheet1', function ($sheet) use ($datas) {
                $sheet->setAutoSize(true);
                $sheet->row(1, $datas['rowTitle']);
                $sheet->fromArray($datas['listExport'], null, 'A2', false, false);

                $sheet->cells($this->cellsHead($datas['rowTitle']), function ($cells) {
                    $cells->setBackground('#AAAAFF');
                });
            });
        })->download($format);
    }

    public function cellsHead($rowTitle)
    {
        $size = count($rowTitle);
        switch ($size) {
            case 1:
                $cellsHead = 'A1:A1';
                break;
            case 2:
                $cellsHead = 'A1:B1';
                break;
            case 3:
                $cellsHead = 'A1:C1';
                break;
            case 4:
                $cellsHead = 'A1:D1';
                break;
            case 5:
                $cellsHead = 'A1:E1';
                break;
            case 6:
                $cellsHead = 'A1:F1';
                break;
            case 7:
                $cellsHead = 'A1:G1';
                break;
            case 8:
                $cellsHead = 'A1:H1';
                break;
            case 9:
                $cellsHead = 'A1:I1';
                break;
            case 10:
                $cellsHead = 'A1:J1';
                break;
            case 11:
                $cellsHead = 'A1:K1';
                break;
            case 12:
                $cellsHead = 'A1:L1';
                break;
            default:
                $cellsHead = 'A1:H1';
        }

        return $cellsHead;
    }
}
