<?php
namespace app\src\core\api;

interface LogsInterface
{
    /**
     * 
     * @param GameInterface $game
     */
    function printStartState(GameInterface $game):void;
    /**
     * 
     * @param GameInterface $game
     * @param int $round
     */
    function printRoundState(GameInterface $game, int $round):void;
    /**
     * 
     * @param GameInterface $game
     */
    function printEndResults(GameInterface $game):void;
}

