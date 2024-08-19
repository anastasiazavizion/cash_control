<?php
namespace App\Http\Controllers;
use App\Services\Report\Creators\PdfReportService;
use App\Services\Report\Creators\ReportService;
use App\Services\Report\Creators\ExcelReportService;
use App\Http\Requests\ReportRequest;
class ReportController extends Controller
{
    function makeReport(ReportService $service)
    {
        return $service->report();
    }

    public function __invoke(ReportRequest $request)
    {
        $reportType = match ($request->validated()['type']){
          'pdf'=>PdfReportService::class,
           default=>ExcelReportService::class
        };
        return $this->makeReport(new $reportType());
    }
}
