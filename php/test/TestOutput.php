<?php

class TestOutput implements Output
{
    public $output = '';



    public function echoln($string)
    {
        $this->output .= $string . PHP_EOL;
    }
}