<?php

namespace App\Helpers;

class FroalaHelper
{
    public static function hash()
    {
        $s3Hash = \FroalaEditor_S3::getHash( config('services.froala'));
        return stripslashes(json_encode($s3Hash));
    }
}