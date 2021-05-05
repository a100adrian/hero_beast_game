<?php
namespace app\src\skills;

interface GeneratorInterface
{
    /**
     * 
     * @param AbstractSkill $skill
     * @param array $stats
     */
    function generate(AbstractSkill $skill, array $stats):void;
}

