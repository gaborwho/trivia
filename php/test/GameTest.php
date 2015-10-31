<?php

require __DIR__ . '/../src/loader.php';
require __DIR__ . '/TestOutput.php';

class GameTest extends PHPUnit_Framework_TestCase
{

    public function testPenaltyWorks()
    {
        $this->markTestSkipped('should be fixed');
        $game = new Game(new TestOutput());
        $game->add("Chet");
        $game->add("Pat");
        $game->add("Sue");

        $game->roll(1);
        $game->wrongAnswer();
        $this->assertEquals(true, $game->inPenaltyBox[0]);

        $game->roll(2);
        $game->wasCorrectlyAnswered();

        $game->roll(2);
        $game->wasCorrectlyAnswered();
        $this->assertEquals(true, $game->inPenaltyBox[0]);

        $game->roll(1);
        $game->wasCorrectlyAnswered();
        $this->assertEquals(false, $game->inPenaltyBox[0]);
    }

}