<?php
namespace app\src\core\api;

use app\src\factory\CharacterCreator;
use app\src\characters\AbstractCharacter;

interface ApplicationInterface
{
    /**
     * 
     */
    function start():void;
    /**
     * 
     * @param CharacterCreator $creator
     * @return AbstractCharacter
     */
    function buildCharacter(CharacterCreator $creator): AbstractCharacter;
}

