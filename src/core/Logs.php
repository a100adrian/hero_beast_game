<?php
namespace app\src\core;

use app\src\core\api\LogsInterface;
use app\src\core\api\GameInterface;

class Logs implements LogsInterface
{
    public function printStartState(GameInterface $game):void
    {
        echo "
            Start Battle \n
        =========================================================== \n
            Hero Name: \e[93m".$game->getHero()->getName()."\e[39m 
            Hero Health: \e[93m".$game->getHero()->getHealth()."\e[39m
            Hero Strength: \e[93m".$game->getHero()->getStrength()."\e[39m
            Hero Speed: \e[93m".$game->getHero()->getSpeed()."\e[39m
            Hero Defence: \e[93m".$game->getHero()->getDefence()."\e[39m
            Hero Luck: \e[93m".$game->getHero()->getLuck()."\e[39m
            Hero Skills: \e[93m";
                $skills = "";
                foreach ($game->getHero()->getSkills() as $skill){
                    
                    $skills .= $skill->getName() .', ';
                    
                }
                echo rtrim($skills, ' ,');
            echo "\e[39m
            
            Beast Name: \e[91m".$game->getBeast()->getName()."\e[39m
            Beast Health: \e[91m".$game->getBeast()->getHealth()."\e[39m
            Beast Strength: \e[91m".$game->getBeast()->getStrength()."\e[39m
            Beast Speed: \e[91m".$game->getBeast()->getSpeed()."\e[39m
            Beast Defence: \e[91m".$game->getBeast()->getDefence()."\e[39m
            Beast Luck: \e[91m".$game->getBeast()->getLuck()."\e[39m \n
        ";
    }
    
    public function printRoundState(GameInterface $game, int $round):void
    {
        echo "
            Round: $round \n
        ================================================================
            Attacker: ".$game->getAttacker()->getName()."
            Attacker Health: ".$game->getAttacker()->getHealth()."
            ";

        if(!empty($game->getAttackerUsedSkills())){
            
            echo "Attacker used skills: ";
            foreach ($game->getAttackerUsedSkills() as $skill){
                
                echo $skill."\n";
            }
        }
        echo "
            Defender: ".$game->getDefender()->getName()."
            Defender Health: ".$game->getDefender()->getHealth()."
        ";
        
        if(!empty($game->getDefenderUsedSkills())){
            
            echo "Defender used skills: ";
            foreach ($game->getDefenderUsedSkills() as $skill){
                
                echo $skill."\n";
            }
        }
        
        if($game->getDefenderWasLucky() === true){
            
            echo "\nDefender: ".$game->getDefender()->getName()." was lucky, no damage was taken \n";
        }
        
    }
    
    public function printEndResults(GameInterface $game):void
    {
        echo "_________________________________________________________________
              Winner: \e[92m".$game->getWinner()->getName() ." \e[39m\n";
    }
    
}