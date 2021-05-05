<?php
namespace app\src\core\api;

use app\src\characters\AbstractCharacter;

interface GameInterface
{
    /**
     * 
     * @param AbstractCharacter $hero
     * @return self
     */
    function setHero(AbstractCharacter $hero):self;
    /**
     * 
     * @param AbstractCharacter $beast
     * @return self
     */
    function setBeast(AbstractCharacter $beast):self;
    /**
     * 
     * @return AbstractCharacter
     */
    function getHero():AbstractCharacter;
    /**
     * 
     * @return AbstractCharacter
     */
    function getBeast():AbstractCharacter;
    /**
     * @return void
     */
    function begin():void;
    /**
     * 
     * @return AbstractCharacter
     */
    function getWinner(): AbstractCharacter;
    /**
     * 
     * @return AbstractCharacter
     */
    function getAttacker():AbstractCharacter;
    /**
     * 
     * @return AbstractCharacter
     */
    function getDefender():AbstractCharacter;
}

