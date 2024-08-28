<?php

namespace App\Services\Report\Creators;

use App\Services\Report\Contracts\ReportServiceContract;
use Illuminate\Support\Facades\Storage;

abstract class ReportService
{
    abstract protected function getReportService() : ReportServiceContract;

    public function report()
    {
        $path = $this->getReportService()->createReport();
        return  response()->download(storage_path('app/public/'.$path));
    }

}
