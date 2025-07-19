<?php

namespace App\Helpers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class CommonHelper
{

    /**
     * Common method to upload file on the specified path.
     *
     * @param File $file
     * @param string $folderPath
     * @param string $disk
     * @return string
     */

    public static function uploadFile($file, $folderPath, $disk=null)
    {
        $disk = $disk ? $disk : config('constants.storage_disk');
        $filePath = $folderPath . "/" . Str::random(5) . "-" . time() . "." . $file->getClientOriginalExtension();
        Storage::disk($disk)->put($filePath, File::get($file));

        return $filePath;
    }
}
