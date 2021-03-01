<?php

namespace App\Helpers;

class DebugHelpers
{
    public static function toRawQuery($query, $showQuery = true, $limit = 10)
    {
        // get(), paginate() 와 같은 데이터를 가져오기 전에 사용해야한다.

        if (env('APP_DEBUG')) {
            if ($showQuery) {
                return dd(array_reduce($query->getBindings(), function($sql, $binding){
                    return preg_replace('/\?/', is_numeric($binding) ? $binding : "'".$binding."'" , $sql, 1);
                }, $query->toSql()));
            } else {
                dd($query->limit($limit)->get());
            }
        }
    }
}