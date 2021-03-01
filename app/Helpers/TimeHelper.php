<?php

namespace App\Helpers;
use Illuminate\Support\Facades\Lang;

use Carbon\Carbon;

class TimeHelper
{
    public static function timeAgo( $time )
    {
        $now	= time();
        $diff	= $now - $time;

        if ( $diff < 60 )
            return Lang::get('article.time.since.now');

        else if ( $diff < 3600 )
            return str_replace( '{num}', ( $out = round( $diff / 60 ) ), $out == 1 ? Lang::get('article.time.since.minute') : Lang::get('article.time.since.minutes') );

        else if ( $diff < 3600 * 24 )
            return str_replace( '{num}', ( $out = round( $diff / 3600 ) ), $out == 1 ? Lang::get('article.time.since.hour') : Lang::get('article.time.since.hours') );

        else if ( $diff < 3600 * 24 * 2 )
            return Lang::get('article.time.since.yesterday');

        else
            return strftime( date( 'Y', $time ) == date( 'Y' ) ? Lang::get('article.time.since.format') : Lang::get('article.time.since.format_year'), $time );
    }

    public static function timestampToString($time, $utc = 'UTC', $timezone = 'Asia/Seoul')
    {
        if ($time) {
            return Carbon::parse($time, $utc)->tz($timezone)->toDateTimeString();
        }

        return null;
    }

    public static function nowToString()
    {
        return Carbon::now()->toDateTimeString();
    }

    public static function todayToString()
    {
        return Carbon::now()->toTimeString();
    }

    public static function addDay($day)
    {
        return Carbon::now()->addDay($day);
    }

}