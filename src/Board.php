<?php

namespace Dominoes;

use Exception;

/**
 * The board holding the played tiles.
 */
class Board {

  /**
   * The board of tiles.
   *
   * @var Tile[]
   */
  private $board;

  /**
   * Constructor.
   *
   * @param \Dominoes\Tile $tile
   *   The first tile on the board.
   */
  public function __construct(Tile $tile) {
    $this->board = [$tile];
    print 'Created new board with the first tile: ' . $tile . PHP_EOL;
  }

  /**
   * Add a tile to the board.
   *
   * @param \Dominoes\Tile $tile
   *   The tile to add.
   */
  public function addTileToBoard(Tile $tile): void {
    // Check if we can add it to the start of the board.
    $firstValueOnBoard = $this->getFirstValueOnBoard();
    if ($tile->getFirst() === $firstValueOnBoard) {
      // We need to rotate the tile.
      $tile->rotateTile();
    }
    if ($tile->getSecond() === $firstValueOnBoard) {
      array_unshift($this->board, $tile);
      return;
    }

    // Check if we can add it to the end of the board.
    $endValueOnBoard = $this->getEndValueOnBoard();
    if ($tile->getSecond() === $endValueOnBoard) {
      // We need to rotate the tile.
      $tile->rotateTile();
    }
    if ($tile->getFirst() === $endValueOnBoard) {
      array_push($this->board, $tile);
      return;
    }

    // Somehow we've called this while the tile can't be added. Throw exception.
    throw new Exception("Unable to add {$tile} to the board");
  }

  /**
   * Gets the first (most left) value of the tile on the board.
   *
   * @return int
   *   The first value.
   */
  public function getFirstValueOnBoard(): int {
    return reset($this->board)->getFirst();
  }

  /**
   * Gets the last (most right) value of the tile on the board.
   *
   * @return int
   *   The last value.
   */
  public function getEndValueOnBoard(): int {
    return end($this->board)->getSecond();
  }

  /**
   * {@inheritdoc}
   */
  public function __toString(): string {
    if (empty($this->board)) {
      return 'The board is empty.';
    }
    $output = 'Board is now:';
    foreach ($this->board as $tile) {
      $output .= ' ' . $tile;
    }
    return $output;
  }

}
