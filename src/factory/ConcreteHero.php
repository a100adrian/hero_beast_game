<?php
namespace app\src\factory;

use app\src\characters\Hero;
use app\src\characters\AbstractCharacter;
use app\src\config\StatsGeneratorInterface;
use app\src\config\ConfigInterface;


class ConcreteHero extends CharacterCreator
{
    private StatsGeneratorInterface $statsGeneratorObject;
    private array $config;
    
    public function __construct(StatsGeneratorInterface $statsGeneratorObject, array $config)
    {
        $this->statsGeneratorObject = $statsGeneratorObject;
        $this->config = $config;
    }
    
    public function factoryMethod(): AbstractCharacter
    {
        return new Hero($this->statsGeneratorObject, $this->config);
    }
}

