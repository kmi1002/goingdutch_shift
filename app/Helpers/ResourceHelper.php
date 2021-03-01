<?php
namespace App\Helpers;

class ResourceHelper
{
    public static function path($file_name) {
        if (env('APP_ENV') == 'local') {
            return '/img/'.$file_name;
        } else {
            return env('AWS_S3_ASSESST_V1_URL').$file_name;
        }
    }
}