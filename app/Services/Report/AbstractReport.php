<?php
namespace App\Services\Report;

use Illuminate\Support\Facades\Storage;

abstract class AbstractReport
{

    public function makeDir($directory)
    {
        if(!Storage::exists($directory)){
            Storage::makeDirectory($directory);
        }
    }

    public function getPath($directory, $extension): string
    {
        return $directory.'/'.'report_' . date('Ymd_His') . ".$extension";
    }

}
