<?php

namespace App;

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
}