<?php
namespace app\src\skills;

abstract class AbstractSkill
{
    const ATTACK_TRIGGER = 0;
    const DEFENCE_TRIGGER = 1;
    
    private string $name;
    private int $chance;
    private int $triggerType;
    private int $multiplier;
    
    public function __construct(GeneratorInterface $generator, array $stats)
    {
        $generator->generate($this, $stats);
    }
    
    public function setName(string $name):self
    {
        $this->name = $name;
        return $this;
    }
    
    public function getName():string
    {
        return $this->name;
    }
    
    public function setChance(int $chance):self
    {
        $this->chance = $chance;
        return $this;
    }
    
    public function getChance():int
    {
        return $this->chance;
    }
    
    public function setTrigger(int $triggerType):self
    {
        $this->triggerType = $triggerType;
        return $this;
    }
    
    public function getTrigger():int
    {
        return $this->triggerType;
    }
    
    public function setMultiplier(int $multiplier):self
    {
        $this->multiplier = $multiplier;
        return $this;
    }
    
    public function getMultiplier():int
    {
        return $this->multiplier;
    }
    
}

