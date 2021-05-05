<?php
namespace app\src\factory;

use app\src\characters\Beast;
use app\src\characters\AbstractCharacter;
use app\src\config\StatsGeneratorInterface;
use app\src\config\ConfigInterface;

class ConcreteBeast extends CharacterCreator
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
        return new Beast($this->statsGeneratorObject, $this->config);
    }
}

