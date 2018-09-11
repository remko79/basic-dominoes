<?php

namespace Dominoes;

/**
 * The game controller.
 */
class Game {

  /**
   * A list of available tiles.
   *
   * @var \Dominoes\Tile[]
   */
  private $availableTiles;

  /**
   * A list of players.
   *
   * @var \Dominoes\Player[]
   */
  private $players;

  /**
   * The current player.
   *
   * @var int
   */
  private $currentPlayer;

  /**
   * The current board.
   *
   * @var \Dominoes\Board
   */
  private $board;

  /**
   * Constructor. Initializes the game.
   *
   * @param array $playerNames
   *   Names of the players.
   */
  public function __construct(array $playerNames) {
    // Initialize the tiles.
    $this->availableTiles = [];
    for ($first = 0; $first < 7; ++$first) {
      for ($second = $first; $second < 7; ++$second) {
        $this->availableTiles[] = new Tile($first, $second, FALSE);
      }
    }
    shuffle($this->availableTiles);

    // Initialize the players.
    $this->players = [];
    foreach ($playerNames as $playerName) {
      $player = new Player($playerName);
      $player->addTiles(array_splice($this->availableTiles, 0, 7));
      $this->players[] = $player;
    }
    $this->currentPlayer = 0;

    // Initialize the board.
    $this->board = new Board($this->getNextAvailableTile());
  }

  /**
   * Get the next available tile.
   *
   * @return \Dominoes\Tile|null
   *   The next tile of NULL when no tiles left.
   */
  public function getNextAvailableTile(): ?Tile {
    return array_pop($this->availableTiles);
  }

  /**
   * Run the game.
   *
   * @return bool
   *   TRUE when someone one, FALSE when there is a draw.
   */
  public function run(): bool {
    do {
      $player = $this->players[$this->currentPlayer];
      if (!$this->playTileForPlayer($player)) {
        $this->pickTileAndPlay($player);
      }

      if (!$player->hasTiles()) {
        print "Player {$player} has won!" . PHP_EOL;
        return TRUE;
      }

      $this->setNextPlayer();
    } while (!empty($this->availableTiles));

    print 'Game is a tie!' . PHP_EOL;
    return FALSE;
  }

  /**
   * Player picks tiles until he can play.
   *
   * @param \Dominoes\Player $player
   *   The player.
   */
  private function pickTileAndPlay(Player $player): void {
    $newTile = $this->getNextAvailableTile();
    $msg = "${player} can't play, ";
    if ($newTile === NULL) {
      print $msg . "no more tiles left!" . PHP_EOL;
      return;
    }

    print $msg . "drawing tile ${newTile}" . PHP_EOL;
    $player->addTiles([$newTile]);
    if (!$this->playTileForPlayer($player)) {
      $this->pickTileAndPlay($player);
    }
  }

  /**
   * Plays one of the player's tiles.
   *
   * @param \Dominoes\Player $player
   *   The player.
   *
   * @return bool
   *   TRUE if a tile was played, FALSE when not.
   */
  private function playTileForPlayer(Player $player): bool {
    $playerTile = $player->getTileToPlay($this->board->getFirstValueOnBoard(), $this->board->getEndValueOnBoard());
    if ($playerTile === NULL) {
      return FALSE;
    }
    print "{$player} plays ${playerTile} ...." . PHP_EOL;
    $this->board->addTileToBoard($playerTile);
    print $this->board . PHP_EOL;
    return TRUE;
  }

  /**
   * Set the next player.
   */
  private function setNextPlayer(): void {
    $this->currentPlayer++;
    if ($this->currentPlayer >= count($this->players)) {
      $this->currentPlayer = 0;
    }
  }

}
