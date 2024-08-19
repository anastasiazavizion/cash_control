<?php

namespace App\Services\Report;

use App\Exports\PaymentExport;
use App\Services\Report\Contracts\ReportServiceContract;
use Maatwebsite\Excel\Facades\Excel;

class ExcelReport extends  AbstactReport implements ReportServiceContract
{
    private string $directory = 'reports/excel';

    public function createReport()
    {
        $this->makeDir($this->directory);
        $path = $this->getPath($this->directory, 'xlsx');
        Excel::store(new PaymentExport(), $path);
        return  $path;
    }
}
