<?php

class RandomProvider implements DataProvider
{

    public function roll()
    {
        return rand(0, 5) + 1;
    }



    public function answer()
    {
        return rand(0, 9);
    }

}