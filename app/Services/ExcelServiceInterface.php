<?php
namespace App\Services;

interface ExcelServiceInterface extends BaseServiceInterface
{
    public function export($datas, $fileName, $format = 'xlsx');
}
