<?php
namespace app\tests;

use app\src\core\Application;
use app\src\factory\ConcreteHero;
use app\src\config\StatsGenerator;
use app\src\config\Config;
use app\src\factory\ConcreteBeast;
use PHPUnit\Framework\TestCase;
use app\src\characters\AbstractCharacter;
use app\src\core\api\GameInterface;

class GameTest extends TestCase
{
    public function test_if_characters_are_instance_of_abstract_class()
    {
        $app = new Application();
        
        $model1 = $app->buildCharacter(new ConcreteHero(new StatsGenerator(), Config::HERO_STATS));
        $model1->setName('name');
        
        $model2 = $app->buildCharacter(new ConcreteBeast(new StatsGenerator(), Config::BEAST_STATS));
        $model2->setName('name');
        
        $subject = $app->game->setHero($model1);
        $subject = $app->game->setBeast($model2);
        
        $actual1 = $subject->getHero();
        $actual2 = $subject->getBeast();
        
        $this->assertInstanceOf(AbstractCharacter::class, $actual1);
        $this->assertInstanceOf(AbstractCharacter::class, $actual2);
    }
    
    public function test_if_game_is_an_instance_of_game_interface()
    {
        $app = new Application();
        
        $model1 = $app->buildCharacter(new ConcreteHero(new StatsGenerator(), Config::HERO_STATS));
        $model1->setName('name');
        
        $model2 = $app->buildCharacter(new ConcreteBeast(new StatsGenerator(), Config::BEAST_STATS));
        $model2->setName('name');
        
        $subject = $app->game->setHero($model1);
        
        $actual = $subject->getHero();
        
        $this->assertInstanceOf(GameInterface::class, $app->game);
    }
}

