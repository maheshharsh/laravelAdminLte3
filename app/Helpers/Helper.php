<?php

namespace App\Helpers;

use DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class Helper {

    public static function genrateOtp() {
        $otp = random_int(1000, 9999);
        return $otp;
    }

    /**
     * 
     * @param array $data
     */
    public static function saveOtp($data) {
        DB::table('otps')->insert($data);
    }

    /**
     * Common method to upload file on the specified path.
     * 
     * @param File $file
     * @param string $folderPath
     * @return string
     */
    public static function uploadFile($file, $folderPath) {
        $filePath = $folderPath . "/" . Str::random(5) . "_" . time() . "." . $file->getClientOriginalExtension();
        Storage::disk(config('constants.storage_disk'))->put($filePath, File::get($file), 'public');
        return $filePath;
    }

}
