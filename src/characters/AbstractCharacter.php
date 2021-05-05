<?php
namespace app\src\characters;


use app\src\config\StatsGeneratorInterface;

abstract class AbstractCharacter
{
    private string $name;
    private int $health;
    private int $strength;
    private int $defence;
    private int $speed;
    private int $luck;
    private array $skills;
    
    public function __construct(StatsGeneratorInterface $statsGenerator, $stats=[])
    {
        $statsGenerator->generate($this, $stats);
    }
    
    abstract public function getSkills():array;
    
    public function setName(string $name):self
    {
        $this->name = $name;
        return $this;
    }
    
    public function getName():string
    {
        return $this->name;
    }
    
    public function setHealth(int $health):self
    {
        $this->health = $health;
        return $this;
    }
    
    public function getHealth():int
    {
        return $this->health;
    }
    
    public function setStrength(int $strength):self
    {
        $this->strength = $strength;
        return $this;
    }
    
    public function getStrength():int
    {
        return $this->strength;
    }
    
    public function setDefence(int $defence):self
    {
        $this->defence = $defence;
        return $this;
    }
    
    public function getDefence():int
    {
        return $this->defence;
    }
    
    public function setSpeed(int $speed):self
    {
        $this->speed = $speed;
        return $this;
    }
    
    public function getSpeed():int
    {
        return $this->speed;
    }
    
    public function setLuck(int $luck):self
    {
        $this->luck = $luck;
        return $this;
    }
    
    public function getLuck():int
    {
        return $this->luck;
    }
    
}

