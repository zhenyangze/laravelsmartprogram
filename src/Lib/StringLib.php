<?php 
namespace yangze\LaravelSmartprogram\Lib;

class StringLib
{
    public static function getHumpName(String $value)
    {
        return lcfirst(str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $value))));
    }
}
