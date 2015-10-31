<?php

// science 2 pont
// 5, 9 history

// 25 perc játékidő
// legmagasabb pont
// 60 sec a max válaszidő

// pénznem
// játékosok száma

require __DIR__ . '/src/loader.php';

$runner = new GameRunner(new RandomProvider());
$runner->run();