<?php

/**
 * @file
 * The game.
 */

use Dominoes\Game;

require_once __DIR__ . '/vendor/autoload.php';

do {
  $game = new Game(['Alice', 'Bob']);
  $finished = $game->run();
  print "=====================" . PHP_EOL;
} while (!$finished);
