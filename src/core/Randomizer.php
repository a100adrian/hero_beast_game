<?php
namespace app\src\core;

use app\src\core\api\RandomizerInterface;

class Randomizer implements RandomizerInterface
{
    //private static $RSeed = 0;
    
//     private static function getSeed()
//     {
//         return time();
//     }
    
//     public static function generate(int $min, int $max = 9999999):int
//     {   
//         self::$RSeed = (self::getSeed() * 125) % 2796203;
        
//         return self::$RSeed % ($max - $min + 1) + $min;
//     }

    public static function generate(int $min, int $max):int
    {
        return mt_rand($min, $max);
    }
}

