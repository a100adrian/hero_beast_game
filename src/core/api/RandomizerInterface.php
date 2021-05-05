<?php
namespace app\src\core\api;

interface RandomizerInterface
{
    /**
     * 
     * @param int $min
     * @param int $max
     * @return int
     */
    static function generate(int $min, int $max):int;
}

