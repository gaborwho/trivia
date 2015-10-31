<?php

class TestCaseGenerator
{
    public function generate()
    {
        for ($i = 0; $i < 100; $i++)
        {
            $maxTests = 100;

            $rolls = [];
            $winners = [];

            for ($n = 1; $n < $maxTests; $n++)
            {
                $rolls[] = rand(0, 5) + 1;
                $winners[] = rand(0, 9);
            }

            $rollsString = implode(',', $rolls) . ',';
            $winnersString = implode(',', $winners) . ',';

            $file = fopen("testdata/input_{$i}.txt", 'w');
            fwrite($file, "0-9\n");
            fwrite($file, $winnersString . "\n\n");
            fwrite($file, "1-6\n");
            fwrite($file, $rollsString . "\n");
            fclose($file);
        }
    }
}

$generator = new TestCaseGenerator();
$generator->generate();
