<?php
namespace App\Services\Report;

use Illuminate\Support\Facades\Storage;

abstract class AbstactReport
{

    public function makeDir($directory)
    {
        if(!Storage::exists($directory)){
            Storage::makeDirectory($directory);
        }
    }

    public function getPath($directory, $extension)
    {
        return $directory.'/'.'report_' . date('Ymd_His') . ".$extension";
    }

}
