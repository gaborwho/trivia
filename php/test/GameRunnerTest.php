<?php

require __DIR__ . '/../src/loader.php';
require __DIR__ . '/TestDataProvider.php';
require __DIR__ . '/TestOutput.php';

class GameRunnerTest extends PHPUnit_Framework_TestCase
{

    private $output;



    /**
     * @dataProvider testCases
     */
    public function testRun($case, $rolls, $answers)
    {
        $outputter = new TestOutput();


        $runner = new GameRunner($outputter, new TestDataProvider($rolls, $answers));
        $runner->run();

        $this->assertEquals($this->getExpected($case), $outputter->output);
    }



    public function echoln($string)
    {
        $this->output .= $string . PHP_EOL;
    }



    public function testCases()
    {
        $cases = array();
        for ($i = 0; $i < 100; $i++)
        {
            $testData = $this->getTestData("testdata/input_{$i}.txt");
            $cases[] = array($i, $testData['rolls'], $testData['answers']);
        }
        return $cases;
    }



    private function getTestData($fileName)
    {
        $testDataFile = __DIR__ . "/{$fileName}";
        $lines = file($testDataFile);
        $answers = explode(",", $lines[1]);
        $rolls = explode(",", $lines[4]);

        unset($answers[count($answers) - 1]);
        unset($rolls[count($rolls) - 1]);

        return array(
            'answers' => $answers,
            'rolls' => $rolls
        );
    }



    private function getExpected($case)
    {
        $expectedOutputFile = __DIR__ . "/testdata/output_{$case}.txt";
        return file_get_contents($expectedOutputFile);
    }

}

