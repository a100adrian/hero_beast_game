<?php
namespace app\src\skills;

class Generator implements GeneratorInterface
{
    public function generate(AbstractSkill $skill, array $stats):void
    {
        if(empty($stats)){
            
            throw new \Exception("Stats cannot be empty.");
        }
        
        foreach ($stats as $key=>$value){
            $method = sprintf("set%s", ucfirst(strtolower($key)));
            if(!method_exists($skill, $method)){
                throw new \Exception(sprintf("Method %s does not exist.", $method));
            }
            $skill->$method($value);
        }
    }
}

