<?php

namespace App\Helpers;

class IPHelper
{
	public static function realIP()
	{
        // https://stackoverflow.com/questions/13646690/how-to-get-real-ip-from-visitor
        if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER) && !empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',') > 0 ) {
                $addr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
                return trim($addr[0]);
            } else {
                return $_SERVER['HTTP_X_FORWARDED_FOR'];
            }
        } else {
            return $_SERVER['REMOTE_ADDR'];
        }
	}
}