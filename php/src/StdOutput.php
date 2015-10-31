<?php

class StdOutput implements Output
{
    public function echoln($string)
    {
        echo $string . "\n";
    }
}