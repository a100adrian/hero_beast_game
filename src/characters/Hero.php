<?php
namespace app\src\characters;

use app\src\characters\abstractCharacter;
use app\src\skills\AbstractSkill;
use app\src\factory\SkillCreator;

class Hero extends abstractCharacter
{
    public function buildSkills(SkillCreator $creator)
    {
        $this->skills[] = $creator->create();
    }
    
    public function setSkills(AbstractSkill $skill): self
    {
        $this->skills[] = $skill;
        return $this;
    }
    
    public function getSkills(): array
    {
        return $this->skills;
    }
}

