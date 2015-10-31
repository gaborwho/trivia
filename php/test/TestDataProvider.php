<?php

class TestDataProvider implements DataProvider
{

    private $rolls;
    private $answers;



    public function __construct($rolls, $answers)
    {
        $this->rolls = $rolls;
        $this->answers = $answers;
    }



    public function roll()
    {
        return array_shift($this->rolls);
    }



    public function answer()
    {
        return array_shift($this->answers);
    }
}