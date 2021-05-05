<?php
namespace app\src\factory;

use app\src\skills\AbstractSkill;

abstract class SkillCreator
{
    abstract public function factoryMethod():AbstractSkill;
    
    public function create()
    {
        return $this->factoryMethod();
    }
}

