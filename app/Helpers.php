<?php

namespace App;

use Illuminate\Support\Str;
use Laravolt\Avatar\Facade as Avatar;

class Helpers
{
    /**
     * Create User Image via Laravolt
     * 
     * @param string $name
     * @return string a string of Image Path
     * */
    public static function convertNameToImage($name = null)
    {
        return (env('APP_ENV') != 'testing') ? Avatar::create($name)->toBase64() : null;
    }

    /**
     * Cut the convert Text
     * 
     * @param string $name
     * @return string a string of Image Path
     * */
    public static function cutConvertedText($text = null, $length = 25)
    {
        $html = strip_tags($text);
        return Str::limit($html, $length, '...');
    }
}