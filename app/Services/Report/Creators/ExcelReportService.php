<?php

namespace App\Services\Report\Creators;

use App\Services\Report\Contracts\ReportServiceContract;
use App\Services\Report\ExcelReport;

class ExcelReportService extends ReportService
{
    protected function getReportService(): ReportServiceContract
    {
        return new ExcelReport();
    }
}
