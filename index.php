<?php

use app\src\core\Application;
use app\src\factory\ConcreteHero;
use app\src\factory\ConcreteBeast;
use app\src\factory\ConcreteSkill;
use app\src\config\Config;
use app\src\config\StatsGenerator;
use app\src\skills\Generator;

require_once __DIR__.'/vendor/autoload.php';

$app = new Application();

$hero = $app->buildCharacter(new ConcreteHero(new StatsGenerator(), Config::HERO_STATS));
$beast = $app->buildCharacter(new ConcreteBeast(new StatsGenerator(), Config::BEAST_STATS));

$hero->setName(Config::HERO_NAME);
$beast->setName(Config::BEATS_NAME);

$hero->buildSkills(new ConcreteSkill(new Generator(), Config::MAGIC_SHIELD));
$hero->buildSkills(new ConcreteSkill(new Generator(), Config::RAPID_STRIKE));

$app->game->setHero($hero);
$app->game->setBeast($beast);

$app->start();