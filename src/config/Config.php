<?php
namespace app\src\config;

use app\src\skills\AbstractSkill;
use app\src\config\ConfigInterface;

class Config implements ConfigInterface
{
    const HERO_NAME = "Orderus";
    const BEATS_NAME = "Wild Beast";
    
    const ROUNDS = 20;
    
    const HERO_STATS = [
        'health'    =>  [70, 100],
        'strength'  =>  [70, 80],
        'speed'     =>  [40, 50],
        'defence'   =>  [45, 55],
        'luck'      =>  [10, 30]
    ];
    
    const BEAST_STATS = [
        'health'    =>  [60, 90],
        'strength'  =>  [60, 90],
        'speed'     =>  [40, 60],
        'defence'   =>  [40, 60],
        'luck'      =>  [25, 40]
    ];
    
    const RAPID_STRIKE  = [
        'name'          => 'Rapid Strike',
        'chance'        => 10,
        'multiplier'    => 2,
        'trigger'       => AbstractSkill::ATTACK_TRIGGER
    ];
    
    const MAGIC_SHIELD = [
        'name'          => 'Magic Shield',
        'multiplier'    => 2,
        'chance'        => 20,
        'trigger'       => AbstractSkill::DEFENCE_TRIGGER
    ];
}

