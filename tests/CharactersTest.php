<?php
namespace app\tests;

use PHPUnit\Framework\TestCase;
use app\src\core\Application;
use app\src\factory\ConcreteHero;
use app\src\config\StatsGenerator;
use app\src\config\Config;
use app\src\skills\Generator;
use app\src\factory\ConcreteSkill;

class CharactersTest extends TestCase
{
    
    public function test_if_character_properties_are_set()
    {
        $app = new Application();
        
        $stats = [
            'health'    =>  [70, 100],
            'strength'  =>  [70, 80],
            'speed'     =>  [40, 50],
            'defence'   =>  [45, 55],
            'luck'      =>  [10, 30]
        ];
        
        $model = $app->buildCharacter(new ConcreteHero(new StatsGenerator(), $stats));
        
        $model->setName('name');
        
        $model->buildSkills(new ConcreteSkill(new Generator(), Config::RAPID_STRIKE));
        
        $this->assertNotEmpty($model->getName());
        $this->assertNotEmpty($model->getDefence());
        $this->assertNotEmpty($model->getLuck());
        $this->assertNotEmpty($model->getHealth());
        $this->assertNotEmpty($model->getSpeed()); 
        $this->assertNotEmpty($model->getSkills());
    }
    

    public function test_if_empty_stats_exception()
    {
        $this->expectException(\Exception::class);
        
        $app = new Application();
        
        $stats = [
            
        ];
        
        $model = $app->buildCharacter(new ConcreteHero(new StatsGenerator(), $stats));
        
        $subject = new StatsGenerator();
        
        $subject->generate($model, $stats);

    }
    
    public function test_if_missing_stat_min_or_max()
    {
        $this->expectException(\Exception::class);
        
        $app = new Application();
        
        $stats = [
            'health'    =>  [70, 100],
            'strength'  =>  [70, 80],
            'speed'     =>  [40],
            'defence'   =>  [45, 55],
            'luck'      =>  [10, 30]
        ];
        
        $model = $app->buildCharacter(new ConcreteHero(new StatsGenerator(), $stats));
        
        $subject = new StatsGenerator();
        
        $subject->generate($model, $stats);
        
    }
    
    public function test_if_max_is_greater_than_min()
    {        
        $this->expectException(\Exception::class);
        
        $app = new Application();
        
        $stats = [
            'health'    =>  [70, 100],
            'strength'  =>  [70, 80],
            'speed'     =>  [71, 70],
            'defence'   =>  [45, 55],
            'luck'      =>  [10, 30]
        ];
        
        $model = $app->buildCharacter(new ConcreteHero(new StatsGenerator(), $stats));
        
        $subject = new StatsGenerator();
        
        $subject->generate($model, $stats);
    }
    
    public function test_if_stats_values_are_in_range()
    {        
        $app = new Application();
        
        $stats = [
            'health'    =>  [70, 100],
            'strength'  =>  [70, 80],
            'speed'     =>  [7, 70],
            'defence'   =>  [45, 55],
            'luck'      =>  [10, 30]
        ];
        
        $model = $app->buildCharacter(new ConcreteHero(new StatsGenerator(), $stats));
        
        $subject = new StatsGenerator();
        
        $subject->generate($model, $stats);
        
        $this->assertTrue($model->getHealth() >= $stats['health'][0]);
        $this->assertTrue($model->getHealth() <= $stats['health'][1]);
        
        $this->assertTrue($model->getStrength() >= $stats['strength'][0]);
        $this->assertTrue($model->getStrength() <= $stats['strength'][1]);
        
        $this->assertTrue($model->getSpeed() >= $stats['speed'][0]);
        $this->assertTrue($model->getSpeed() <= $stats['speed'][1]);
        
        $this->assertTrue($model->getDefence() >= $stats['defence'][0]);
        $this->assertTrue($model->getDefence() <= $stats['defence'][1]);
        
        $this->assertTrue($model->getLuck() >= $stats['luck'][0]);
        $this->assertTrue($model->getLuck() <= $stats['luck'][1]);
    }
    
}
