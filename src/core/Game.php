<?php
namespace app\src\core;

use app\src\characters\AbstractCharacter;
use app\src\config\ConfigInterface;
use app\src\core\api\GameInterface;
use app\src\core\api\LogsInterface;
use app\src\skills\AbstractSkill;

class Game implements GameInterface
{
    private AbstractCharacter $hero;
    private AbstractCharacter $beast;
    
    private AbstractCharacter $defender;
    private AbstractCharacter $attacker;
    
    private ConfigInterface $config;
    private LogsInterface $logger;
    
    private array $attackerUsedSkills = [];
    private array $defenderUsedSkills = [];
    
    private bool $defenderWasLucky = false;
    
    public function __construct(ConfigInterface $config, LogsInterface $logger)
    {
        $this->config = $config;
        $this->logger = $logger;
    }
    
    /**
     * 
     * {@inheritDoc}
     * @see \app\src\core\api\GameInterface::setHero()
     */
    public function setHero(AbstractCharacter $hero):self
    {
        $this->hero = $hero;
        return $this;
    }
    
    /**
     * 
     * {@inheritDoc}
     * @see \app\src\core\api\GameInterface::getHero()
     */
    public function getHero():AbstractCharacter
    {
        return $this->hero;
    }
    
    /**
     * 
     * {@inheritDoc}
     * @see \app\src\core\api\GameInterface::setBeast()
     */
    public function setBeast(AbstractCharacter $beast):self
    {
        $this->beast = $beast;
        return $this;
    }
    
    /**
     * 
     * {@inheritDoc}
     * @see \app\src\core\api\GameInterface::getBeast()
     */
    public function getBeast():AbstractCharacter
    {
        return $this->beast;
    }
    
    /**
     * 
     * {@inheritDoc}
     * @see \app\src\core\api\GameInterface::getAttacker()
     */
    public function getAttacker():AbstractCharacter
    {
        return $this->attacker;
    }
    
    /**
     * 
     * {@inheritDoc}
     * @see \app\src\core\api\GameInterface::getDefender()
     */
    public function getDefender():AbstractCharacter
    {
        return $this->defender;
    }
    
    public function getDefenderWasLucky():bool
    {
        return $this->defenderWasLucky;
    }
    
    public function getAttackerUsedSkills():array
    {
        return $this->attackerUsedSkills;
    }
    
    public function getDefenderUsedSkills():array
    {
        return $this->defenderUsedSkills;
    }
    
    /**
     * The player with the gratest speed is the attacker.
     * If both players have the same speed, then the one with greatest 
     * luck is the attacker.
     * Default: Hero starts.
     * @return bool
     */
    public function setFirstAttacker():bool
    {
        if($this->hero->getSpeed() > $this->beast->getSpeed()){
            
            $this->attacker = $this->hero;
            $this->defender = $this->beast;
            
            return false;
        }
        
        if($this->hero->getSpeed() < $this->beast->getSpeed()){
            
            $this->attacker = $this->beast;
            $this->defender = $this->hero;
            
            return false;
        }
        
        if($this->hero->getLuck() > $this->beast->getLuck()){
            
            $this->attacker = $this->hero;
            $this->defender = $this->beast;
            
            return false;
        }
        
        if($this->hero->getLuck() < $this->beast->getLuck()){
            
            $this->attacker = $this->beast;
            $this->defender = $this->hero;
            
            return false;
        }
        
        $this->attacker = $this->hero;
        $this->defender = $this->beast;
    }
    
    /**
     * Plays the round
     * Checks if the defender is lucky
     * Updates player health
     * Prints game stats
     * Switch players roles
     * @param int $round
     */
    private function roundPlay(int $round)
    {
        $this->defenderIsLucky();
        $this->updateHealth();
        $this->printStats($round);
        $this->switchRoles();
        
    }
    
    /**
     * @return bool
     */
    private function defenderIsLucky():bool
    {
        $r = Randomizer::generate(0, 100);
        if( $r <= $this->defender->getLuck()){
            $this->defenderWasLucky = true;
            return false;
        }
        $this->defenderWasLucky = false;
        return false;
    }
    
    /**
     * 
     * @return number
     */
    private function getDamage()
    {
        if($this->attacker->getStrength() > $this->defender->getDefence())
        {
            return ($this->attacker->getStrength() - $this->defender->getDefence() 
                            * $this->useSkill());
        }
    }
    
    /**
     * @return number
     */
    private function useSkill()
    {
        $multiplier = 1;
        
        foreach($this->attacker->getSkills() as $skill){
            
            if($skill->getTrigger() === AbstractSkill::ATTACK_TRIGGER)
            {
                $r = Randomizer::generate(0, 100);
                if($r <= $skill->getChance()){
                    
                    $this->attackerUsedSkills[] = $skill->getName();
                    $multiplier = $multiplier * $skill->getMultiplier();
                }
            }
            
            if($skill->getTrigger() === AbstractSkill::DEFENCE_TRIGGER)
            {
                $r = Randomizer::generate(0, 100);
                if($r <= $skill->getChance()){
                    
                    $this->attackerUsedSkills[] = $skill->getName();
                    $multiplier = $multiplier / $skill->getMultiplier();
                }
            }
        }
        
        return $multiplier;
    }

    /**
     * 
     */
    private function updateHealth():void
    {
        $damage = $this->getDamage();
        if($this->defenderWasLucky === true) $damage = 0;
        
        $healthVal = $this->defender->getHealth() - $damage;
        
        if($healthVal < 0) $healthVal = 0;
                
        $this->defender->setHealth($healthVal);
    }
    
    /**
     * 
     * {@inheritDoc}
     * @see \app\src\core\api\GameInterface::begin()
     */
    public function begin():void
    {
        $this->printStartState();
        $this->setFirstAttacker();
        
        for($round = 0; $round <= $this->config::ROUNDS; $round++)
        {
            if($this->isGameOver($round+1)){   
                $this->printEndResults();
                break;
            }
            
            $this->roundPlay($round+1);
            $this->attackerUsedSkills = [];
            $this->defenderUsedSkills = [];
        }
    }
    
    /**
     * 
     * @param int $round
     * @return bool
     */
    private function isGameOver(int $round):bool
    {
        if($this->attacker->getHealth() <= 0 || $this->defender->getHealth() <= 0) return true;
        if($round == $this->config::ROUNDS) return true;
        
        return false;
    }
    
    private function switchRoles():void
    {
        $temp = $this->attacker;
        $this->attacker = $this->defender;
        $this->defender = $temp;
    }
    
    /**
     * 
     * {@inheritDoc}
     * @see \app\src\core\api\GameInterface::getWinner()
     */
    public function getWinner(): AbstractCharacter
    {
        if($this->attacker->getHealth() > $this->defender->getHealth()) return $this->attacker;
        
        return $this->defender;
    }
    
    private function printStats(int $round):void
    {
        $this->logger->printRoundState($this, $round);
    }
    
    private function printStartState():void
    {
        $this->logger->printStartState($this);
    }
    
    private function printEndResults():void
    {
        $this->logger->printEndResults($this);
    }
   
}

