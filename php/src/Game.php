<?php

class Game
{
    /** @var Output */
    private $output;
    var $players;
    var $places;
    var $purses;
    var $inPenaltyBox;

    var $popQuestions;
    var $scienceQuestions;
    var $sportsQuestions;
    var $rockQuestions;

    var $currentPlayer = 0;
    var $isGettingOutOfPenaltyBox;


    const QUESTION_POP = "Pop";


    const QUESTION_SCIENCE = "Science";


    const QUESTION_SPORTS = "Sports";


    const QUESTION_ROCK = "Rock";


    const COINS_TO_WIN = 6;



    public function  __construct($output)
    {
        $this->output = $output;

        $this->players = array();
        $this->places = array(0);
        $this->purses = array(0);
        $this->inPenaltyBox = array(0);

        $this->popQuestions = array();
        $this->scienceQuestions = array();
        $this->sportsQuestions = array();
        $this->rockQuestions = array();

        for ($i = 0; $i < 50; $i++)
        {
            array_push($this->popQuestions, "Pop Question " . $i);
            array_push($this->scienceQuestions, ("Science Question " . $i));
            array_push($this->sportsQuestions, ("Sports Question " . $i));
            array_push($this->rockQuestions, $this->createRockQuestion($i));
        }
    }



    public function add($playerName)
    {
        array_push($this->players, $playerName);
        $this->places[$this->howManyPlayers()] = 0;
        $this->purses[$this->howManyPlayers()] = 0;
        $this->inPenaltyBox[$this->howManyPlayers()] = false;

        $this->output->echoln($playerName . " was added");
        $this->output->echoln("They are player number " . count($this->players));
        return true;
    }



    public function roll($roll)
    {
        $this->output->echoln($this->nameOfCurrentPlayer() . " is the current player");
        $this->output->echoln("They have rolled a " . $roll);

        if ($this->inPenaltyBox[$this->currentPlayer])
        {
            if ($this->canGetOutOfPenaltyBox($roll))
            {
                $this->isGettingOutOfPenaltyBox = true;
                $this->output->echoln($this->nameOfCurrentPlayer() . " is getting out of the penalty box");
                $this->movePlayer($roll);
                $this->askQuestion();
            }
            else
            {
                $this->output->echoln($this->nameOfCurrentPlayer() . " is not getting out of the penalty box");
                $this->isGettingOutOfPenaltyBox = false;
            }

        }
        else
        {
            $this->movePlayer($roll);
            $this->askQuestion();
        }

    }



    public function wasCorrectlyAnswered()
    {
        if ($this->inPenaltyBox[$this->currentPlayer])
        {
            if ($this->isGettingOutOfPenaltyBox)
            {
                $this->output->echoln("Answer was correct!!!!");
                $this->addCoinToPurse();
                $winner = $this->didCurrentPlayerWin();
                $this->jumpToNextPlayer();
                return $winner;
            }
            else
            {
                $this->jumpToNextPlayer();
                return true;
            }
        }
        else
        {
            $this->output->echoln("Answer was corrent!!!!");
            $this->addCoinToPurse();
            $winner = $this->didCurrentPlayerWin();
            $this->jumpToNextPlayer();

            return $winner;
        }
    }



    public function wrongAnswer()
    {
        $this->output->echoln("Question was incorrectly answered");
        $this->sendCurrentPlayerToPenaltyBox();
        $this->jumpToNextPlayer();
        return true;
    }



    private function createRockQuestion($index)
    {
        return "Rock Question " . $index;
    }



    protected function addCoinToPurse()
    {
        $this->purses[$this->currentPlayer]++;
        $this->output->echoln($this->nameOfCurrentPlayer()
            . " now has "
            . $this->purses[$this->currentPlayer]
            . " Gold Coins.");
    }



    protected function sendCurrentPlayerToPenaltyBox()
    {
        $this->output->echoln($this->nameOfCurrentPlayer() . " was sent to the penalty box");
        $this->inPenaltyBox[$this->currentPlayer] = true;
    }



    private function isPlayable()
    {
        return ($this->howManyPlayers() >= 2);
    }



    private function howManyPlayers()
    {
        return count($this->players);
    }



    private function askQuestion()
    {
        if ($this->currentCategory() == self::QUESTION_POP)
        {
            $this->output->echoln(array_shift($this->popQuestions));
        }
        if ($this->currentCategory() == self::QUESTION_SCIENCE)
        {
            $this->output->echoln(array_shift($this->scienceQuestions));
        }
        if ($this->currentCategory() == self::QUESTION_SPORTS)
        {
            $this->output->echoln(array_shift($this->sportsQuestions));
        }
        if ($this->currentCategory() == self::QUESTION_ROCK)
        {
            $this->output->echoln(array_shift($this->rockQuestions));
        }
    }



    private function currentCategory()
    {
        $categoryOfPlace = $this->places[$this->currentPlayer] % 4;

        if ($categoryOfPlace == 0)
        {
            return self::QUESTION_POP;
        }
        else if ($categoryOfPlace == 1)
        {
            return self::QUESTION_SCIENCE;
        }
        else if ($categoryOfPlace == 2)
        {
            return self::QUESTION_SPORTS;
        }
        else
        {
            return self::QUESTION_ROCK;
        }
    }



    private function didCurrentPlayerWin()
    {
        return !($this->coinsInPurseOfCurrentPlayer() == self::COINS_TO_WIN);
    }



    private function jumpToNextPlayer()
    {
        $this->currentPlayer++;
        if ($this->currentPlayer == count($this->players))
        {
            $this->currentPlayer = 0;
        }
    }



    private function movePlayer($roll)
    {
        $this->places[$this->currentPlayer] = $this->places[$this->currentPlayer] + $roll;
        if ($this->places[$this->currentPlayer] > 11)
        {
            $this->places[$this->currentPlayer] = $this->places[$this->currentPlayer] - 12;
        }

        $this->output->echoln($this->nameOfCurrentPlayer()
            . "'s new location is "
            . $this->places[$this->currentPlayer]);
        $this->output->echoln("The category is " . $this->currentCategory());
    }



    private function canGetOutOfPenaltyBox($roll)
    {
        return $roll % 2 != 0;
    }



    private function nameOfCurrentPlayer()
    {
        return $this->players[$this->currentPlayer];
    }



    private function coinsInPurseOfCurrentPlayer()
    {
        return $this->purses[$this->currentPlayer];
    }
}
