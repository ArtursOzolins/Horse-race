<?php

$athletes1 = new stdClass();
$athletes1->symbol = '#';
$athletes1->progress = 0;
$athletes1->winCoef = 5;
$athletes1->trainLVL = [2, 2, 3];

$athletes2 = new stdClass();
$athletes2->symbol = '@';
$athletes2->progress = 0;
$athletes2->winCoef = 4;
$athletes2->trainLVL = [2, 2, 2, 2, 3, 3, 3];

$athletes3 = new stdClass();
$athletes3->symbol = '%';
$athletes3->progress = 0;
$athletes3->winCoef = 3;
$athletes3->trainLVL = [2, 2, 2, 3, 3, 3];

$athletes4 = new stdClass();
$athletes4->symbol = 'Y';
$athletes4->progress = 0;
$athletes4->winCoef = 2;
$athletes4->trainLVL = [2, 2, 2, 3, 3, 3, 3];

$athletes = [$athletes1, $athletes2, $athletes3, $athletes4];
$distance = 70;

echo 'Horses to compete: ' . PHP_EOL;
foreach ($athletes as $value) {
    echo "Horse: {$value->symbol}" . PHP_EOL;
}

// BETTING
$totalCash = 200;
$toBet = readline ('Want to bet? y/n : ');
$bettedHorses = [];
$bettedAmounts = [];
while ($toBet === 'y') {
    $betChoice = readline ('Choose your lucky horse: ');
    array_push($bettedHorses, $betChoice);
    $betAmount = readline ('How much are you willing to put on the table??? : ');
    array_push($bettedAmounts, $betAmount);
    $toBet = readline ('Want to bet on another horse: ');
}
$totalCash -= array_sum($bettedAmounts);

while (max($athletes1->progress, $athletes2->progress, $athletes3->progress, $athletes4->progress) < $distance) {
    echo str_repeat('==', $distance/2) . PHP_EOL;
    echo str_repeat(' ', $athletes4->progress) . $athletes4->symbol . str_repeat(' ', $distance - $athletes4->progress - 1) . PHP_EOL;
    echo str_repeat('- ', $distance/2) . PHP_EOL;
    echo str_repeat(' ', $athletes1->progress) . $athletes1->symbol . str_repeat(' ', $distance - $athletes1->progress - 1) . PHP_EOL;
    echo str_repeat('- ', $distance/2) . PHP_EOL;
    echo str_repeat(' ', $athletes2->progress) . $athletes2->symbol . str_repeat(' ', $distance - $athletes2->progress - 1) . PHP_EOL;
    echo str_repeat('- ', $distance/2) . PHP_EOL;
    echo str_repeat(' ', $athletes3->progress) . $athletes3->symbol . str_repeat(' ', $distance - $athletes3->progress - 1) . PHP_EOL;
    echo str_repeat('==', $distance/2) . PHP_EOL;
    foreach ($athletes as $value) {
        $value->progress += rand(1, $value->trainLVL[rand(0, rand(0, count($value->trainLVL)))]);
    }
    usleep(100000);
}

$winningHorses = [];
$winningCoef = [];
foreach ($athletes as $value) {
    if ($value->progress >= $distance) {
        echo "{$value->symbol} has won! ";
        array_push($winningHorses, $value->symbol);
        array_push($winningCoef, $value->winCoef);
    }
}

$wonBets = [];
for ($i = 0; $i < count($bettedHorses); $i++) {
    for ($j = 0; $j < count($winningHorses); $j++) {
        if ($bettedHorses[$i] === $winningHorses[$j]) {
            $prize = $bettedAmounts[$i] * $winningCoef[$j];
            $wonAmount = $prize - $bettedAmounts[$i];
            $totalCash += $prize;
            array_push($wonBets, $bettedAmounts[$i]);
            echo "You betted {$bettedAmounts[$i]} on {$bettedHorses[$i]}. You have won {$wonAmount}." . PHP_EOL;
        }
    }
}

echo "Remaining funds: {$totalCash}" . PHP_EOL;