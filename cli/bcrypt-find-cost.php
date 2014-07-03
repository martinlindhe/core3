<?php
/**
 * Calculates an appropriate cost parameter for the current system
 */

$timeTarget = 0.2;

$cost = 9;
do {
    $cost++;
    $start = microtime(true);

    $password = new Core\Password\Bcrypt($cost);

    $password->hash("test");
    $end = microtime(true);
} while (($end - $start) < $timeTarget);

echo "Appropriate password_hash() cost found: ".$cost."\n";
