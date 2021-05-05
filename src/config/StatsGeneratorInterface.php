<?php
namespace app\src\config;

use app\src\characters\AbstractCharacter;

interface StatsGeneratorInterface
{
    /**
     * 
     * @param AbstractCharacter $model
     * @param array $stats
     */
    function generate(AbstractCharacter $model, array $stats):void;
}

