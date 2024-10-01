<?php

namespace App\Services\Report\Contracts;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;

interface ReportServiceContract
{
    public function createReport(User|Authenticatable $user);

}
