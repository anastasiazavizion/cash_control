<?php
namespace App\Http\Controllers;
use App\Models\User;
use App\Services\Report\Creators\PdfReportService;
use App\Services\Report\Creators\ReportService;
use App\Services\Report\Creators\ExcelReportService;
use App\Http\Requests\ReportRequest;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    function makeReport(ReportService $service, User|Authenticatable $user)
    {
        return $service->report($user);
    }

    public function __invoke(ReportRequest $request)
    {
        $reportType = match ($request->validated()['type']){
          'pdf'=>PdfReportService::class,
           default=>ExcelReportService::class
        };
        return $this->makeReport(new $reportType(), Auth::user());
    }
}
