<?php
namespace app\src\core;

use app\src\factory\CharacterCreator;
use app\src\config\Config;
use app\src\core\api\ApplicationInterface;
use app\src\characters\AbstractCharacter;
use app\src\core\api\GameInterface;
use app\src\config\ConfigInterface;
use app\src\core\api\LogsInterface;

class Application implements ApplicationInterface
{
    public GameInterface $game;
    private ConfigInterface $config;
    private LogsInterface $logs;
    //public static ApplicationInterface $app;
        
    public function __construct()
    {
        //self::$app = $this;
        $this->config = new Config();
        $this->logs = new Logs();
        $this->game = new Game($this->config, $this->logs);
    }
    
    public function buildCharacter(CharacterCreator $creator): AbstractCharacter
    {
        return $creator->create();
    }
    
    public function start():void
    {
        try {
            $this->game->begin();
        } catch (\Exception $e) {
            print_r($e->getMessage());
        }
    }
    
}

