<?php
namespace app\src\factory;

use app\src\characters\AbstractCharacter;

abstract class CharacterCreator
{
    abstract public function factoryMethod():AbstractCharacter;
    
    public function create()
    {
        return $this->factoryMethod();
    }
}

