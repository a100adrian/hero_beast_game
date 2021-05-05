<?php
namespace app\src\factory;

use app\src\skills\skill;
use app\src\skills\AbstractSkill;
use app\src\skills\GeneratorInterface;

class ConcreteSkill extends SkillCreator
{
   protected GeneratorInterface $skillsGeneratorObject;
   protected array $skills;
   
   public function __construct(GeneratorInterface $skillsGeneratorObject, array $skills)
   {
       $this->skillsGeneratorObject = $skillsGeneratorObject;
       $this->skills = $skills;
   }
   public function factoryMethod():AbstractSkill
   {
       return new Skill(new $this->skillsGeneratorObject, $this->skills);
   }
}

