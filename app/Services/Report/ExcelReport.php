<?php

namespace App\Services\Report;

use App\Exports\PaymentExport;
use App\Models\User;
use App\Services\Report\Contracts\ReportServiceContract;
use Illuminate\Contracts\Auth\Authenticatable;
use Maatwebsite\Excel\Facades\Excel;

class ExcelReport extends  AbstactReport implements ReportServiceContract
{
    private string $directory = 'reports/excel';
    public string $type = 'application/excel';

    public function createReport(User|Authenticatable $user)
    {
        $path = $this->getPath($this->directory, 'xlsx');
        Excel::store(new PaymentExport(), $path, 's3');
        return  $path;
    }
}
