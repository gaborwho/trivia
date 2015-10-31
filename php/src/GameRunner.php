<?php

class GameRunner
{
    /** @var DataProvider */
    private $randomProvider;
    private $output;



    public function __construct(Output $output, DataProvider $randomProvider)
    {
        $this->output = $output;
        $this->randomProvider = $randomProvider;
    }



    public function run()
    {
        $aGame = new Game($this->output);

        $aGame->add("Chet");
        $aGame->add("Pat");
        $aGame->add("Sue");


        do
        {

            $aGame->roll($this->randomProvider->roll());

            if ($this->randomProvider->answer() == 7)
            {
                $notAWinner = $aGame->wrongAnswer();
            }
            else
            {
                $notAWinner = $aGame->wasCorrectlyAnswered();
            }


        }
        while ($notAWinner);
    }
}
  
