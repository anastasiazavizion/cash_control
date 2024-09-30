<?php

namespace App\Services\Report\Creators;

use App\Models\User;
use App\Services\Report\Contracts\ReportServiceContract;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Storage;

abstract class ReportService
{
    abstract protected function getReportService() : ReportServiceContract;

    public function report(User|Authenticatable $user)
    {
        $path = $this->getReportService()->createReport($user);
        $file =  Storage::get($path);
        $headers = [
            'Content-Type' => $this->getReportService()->type,
            'Content-Description' => 'File Transfer',
            'Content-Disposition' => "attachment; filename=report",
            'filename'=> 'report'
        ];
        return response($file, 200, $headers);
    }

}
