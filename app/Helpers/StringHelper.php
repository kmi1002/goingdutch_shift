<?php

namespace App\Helpers;

class StringHelper
{
	// 랜덤 문자열
	// Default		: '0-9', 'a-z', 'A-Z'
	// Lower Case	: 'a-z'
	// HEX			: '0-9', 'a-z'
	// BIN			: '0-1'
    public static function random($length, $ranges = array('0-9', 'a-z', 'A-Z')) {
        
	    // 텍스트 추출
	    $s = '';
        foreach ($ranges as $range) {
            $range = explode('-', $range);
            $last = $range[1];
            
	        $s .= implode(range((array_shift($range)), $last));
		}
		
		// 길이 제한
        while (strlen($s) < $length) {
	        $s .= $s;
		}
		
		// 조합
        return substr(str_shuffle($s), 0, $length);
    }

    static public function statistics($items)
    {
        $type = [];
        foreach ($items as $item) {
            $type[] = $item['name'] . ' : ' . $item['count'];
        }

        return implode(', ', $type);
    }

    static public function plainText($html, $length)
    {
        $html = html_entity_decode($html);
        $html = strip_tags($html, ' \t\n\r\0\x0B\xC2\xA0');

        return mb_substr($html,0, $length, 'utf-8');
    }

}