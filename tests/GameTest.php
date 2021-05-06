<?php
namespace app\tests;

use app\src\core\Application;
use app\src\factory\ConcreteHero;
use app\src\config\StatsGenerator;
use app\src\config\Config;
use app\src\factory\ConcreteBeast;
use PHPUnit\Framework\TestCase;
use app\src\characters\AbstractCharacter;
use app\src\core\Game;
use app\src\core\Logs;
use app\src\factory\ConcreteSkill;
use app\src\skills\Generator;
use Mockery as m;
use function PHPUnit\Framework\assertSame;

class GameTest extends TestCase
{
    private Game $subject;
    private AbstractCharacter $model1;
    private AbstractCharacter $model2;
    private $m;
    
    public function setUp():void
    {
        $app = new Application();
        $this->model1 = $app->buildCharacter(new ConcreteHero(new StatsGenerator(), Config::HERO_STATS));
        $this->model1->setName('hero');
        
        $this->model2 = $app->buildCharacter(new ConcreteBeast(new StatsGenerator(), Config::BEAST_STATS));
        $this->model2->setName('beast');
        
        $this->model1->buildSkills(new ConcreteSkill(new Generator(), Config::MAGIC_SHIELD));
        $this->model1->buildSkills(new ConcreteSkill(new Generator(), Config::RAPID_STRIKE));
        
        $app->game->setHero($this->model1);
        $app->game->setBeast($this->model2);
        
        $this->subject = $app->game;
        
    }
    
    public function test_if_characters_are_instance_of_expected_class()
    {
        $this->subject->begin();
        
        $actual = $this->subject->getHero();
        $this->assertInstanceOf(AbstractCharacter::class, $actual);
        
        $actual = $this->subject->getBeast();
        $this->assertInstanceOf(AbstractCharacter::class, $actual);
        
        $actual = $this->subject->getAttacker();
        $this->assertInstanceOf(AbstractCharacter::class, $actual);
        
        $actual = $this->subject->getDefender();
        $this->assertInstanceOf(AbstractCharacter::class, $actual);
        
        $actual = $this->subject->getWinner();
        $this->assertInstanceOf(AbstractCharacter::class, $actual);
    }
   
    public function test_if_setFirstAttacker_sets_correct_roles()
    {

        //if config ROUNDS = 1;
        
        $this->model1->setSpeed(4);
        $this->model2->setSpeed(2);
        
        $this->model1->setLuck(30);
        $this->model2->setLuck(30);
      
        $m = m::mock(Game::class, [new Config(), new Logs()])
            ->makePartial();
        
        $this->subject = $m;
        $this->subject->setHero($this->model1);
        $this->subject->setBeast($this->model2);
        $this->subject->begin();
        
        $m  ->shouldReceive('setFirstAttacker')
            ->andReturn(false);
                   
        $this->assertEquals($this->subject->getAttacker()->getName(), 
            $this->subject->getHero()->getName());
        
    }
    
    function tearDown():void
    {
        parent::tearDown();
        $container = m::getContainer();
        $this->addToAssertionCount($container->mockery_getExpectationCount());
    }
}
