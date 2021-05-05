<?php
namespace app\tests;

use PHPUnit\Framework\TestCase;
use app\src\core\Application;
use app\src\factory\ConcreteHero;
use app\src\config\StatsGenerator;
use app\src\config\Config;
use app\src\skills\Generator;
use app\src\factory\ConcreteSkill;
use app\src\characters\AbstractCharacter;
use app\src\factory\ConcreteBeast;

class CharactersTest extends TestCase
{
    private Application $subject;
   
    public function setUp():void
    {
        $this->subject = new Application();
    }
    
    public function test_if_character_properties_are_set()
    {
        $model1 = $this->subject->buildCharacter(new ConcreteHero(new StatsGenerator(), Config::HERO_STATS));
        $model1->setName('hero');
        
        $model2 = $this->subject->buildCharacter(new ConcreteBeast(new StatsGenerator(), Config::BEAST_STATS));
        $model2->setName('beast');
        
        $model1->buildSkills(new ConcreteSkill(new Generator(), Config::MAGIC_SHIELD));
        $model1->buildSkills(new ConcreteSkill(new Generator(), Config::RAPID_STRIKE));
        
        $this->assertNotEmpty($model1->getName());
        $this->assertNotEmpty($model1->getDefence());
        $this->assertNotEmpty($model1->getLuck());
        $this->assertNotEmpty($model1->getSpeed());
        $this->assertNotEmpty($model1->getSkills()); 
        $this->assertNotEmpty($model1->getStrength());
        
        $this->assertNotEmpty($model2->getName());
        $this->assertNotEmpty($model2->getDefence());
        $this->assertNotEmpty($model2->getLuck());
        $this->assertNotEmpty($model2->getSpeed());
        $this->assertIsArray($model2->getSkills());
        $this->assertNotEmpty($model2->getStrength());
    }
    

    public function test_if_empty_stats_exception()
    {
        $this->expectException(\Exception::class);
                
        $stats = [
            
        ];
        
        $model = $this->subject->buildCharacter(new ConcreteHero(new StatsGenerator(), $stats));
        
        $stats->generate($model, $stats);
        
        $stats = new StatsGenerator();
        
        $model = $this->subject->buildCharacter(new ConcreteHero(new StatsGenerator(), $stats));
        
        $stats->generate($model, $stats);
        
        $stats = [
            'health'    =>  [70, 100],
            'strength'  =>  [70, 80],
            'speed'     =>  [40],
            'defence'   =>  [45, 55],
            'luck'      =>  [10, 30]
        ];

        $model = $this->subject->buildCharacter(new ConcreteHero(new StatsGenerator(), $stats));
        
        $stats->generate($model, $stats);
        
        $stats = [
            'health'    =>  [70, 100],
            'strength'  =>  [70, 80],
            'speed'     =>  [71, 70],
            'defence'   =>  [45, 55],
            'luck'      =>  [10, 30]
        ];
        
        $model = $this->subject->buildCharacter(new ConcreteHero(new StatsGenerator(), $stats));
        
        generate($model, $stats);
        
        
        $stats = [
            'health'    =>  [70, 100],
            'strength'  =>  [70, 80],
            'speed'     =>  [7, 70],
            'defence'   =>  [45, 55],
            'luck'      =>  [10, 30]
        ];
        
        generate($model, $stats);
        
        $model = $this->subject->buildCharacter(new ConcreteHero(new StatsGenerator(), $stats));
        
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
