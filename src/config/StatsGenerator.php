<?php
namespace app\src\config;

use app\src\characters\AbstractCharacter;
use app\src\core\Randomizer;

class StatsGenerator implements StatsGeneratorInterface
{
    public function generate(AbstractCharacter $model, array $stats):void
    {
        if(empty($stats)){
            throw new \Exception('Stats cannot be empty');
        }
        
        foreach ($stats as $key=>$value){
            if(empty($value[0]) || empty($value[1])){
                throw new \Exception('Min or max '.$key.' is missing.');
            }
            
            if($value[0] > $value[1]){
                throw new \Exception('Min '.$key.' cannot be greater than max value.');
            }
            
            $method = sprintf("set%s", ucfirst(strtolower($key)));
            if(!method_exists($model, $method)){
                throw new \Exception(sprintf('Method %s for '.$model.' does not exist.', $method));
            }
            
            $randomNumber = $this->generateRandomNumber($value[0], $value[1]);
            $model->$method($randomNumber);
        }
    }
    
    private function generateRandomNumber(int $min, int $max)
    {
        return Randomizer::generate($min, $max);
    }
}

