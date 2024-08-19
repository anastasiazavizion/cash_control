<?php

namespace App\Services\Report\Creators;

use App\Services\Report\Contracts\ReportServiceContract;
use App\Services\Report\PdfReport;

class PdfReportService extends ReportService
{

    protected function getReportService(): ReportServiceContract
    {
       return new PdfReport();
    }
}
