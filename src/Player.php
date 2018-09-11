<?php

namespace Dominoes;

/**
 * A player for the game.
 */
class Player {

  /**
   * Player name.
   *
   * @var string
   */
  private $name;

  /**
   * Player tiles.
   *
   * @var array
   */
  private $tiles;

  /**
   * Constructor.
   *
   * @param string $name
   *   Player name.
   */
  public function __construct(string $name) {
    $this->name = $name;
    $this->tiles = [];
  }

  /**
   * Add tiles to the player's tiles.
   *
   * @param \Dominoes\Tile[] $tiles
   *   Tiles to add.
   */
  public function addTiles(array $tiles): void {
    $this->tiles = array_merge($this->tiles, $tiles);
  }

  /**
   * Does the player still has tiles left?
   *
   * @return bool
   *   TRUE when the player still has tiles, FALSE otherwise.
   */
  public function hasTiles(): bool {
    return !empty($this->tiles);
  }

  /**
   * Checks which player's tiles can be played and returns one of them.
   *
   * @param int $firstValue
   *   First value to check.
   * @param int $secondValue
   *   Second value to check.
   *
   * @return \Dominoes\Tile|null
   *   The tile to play or null when the player doesn't have a tile to play.
   */
  public function getTileToPlay(int $firstValue, int $secondValue): ?Tile {
    $playable = $this->getTilesToPlayForValue($firstValue);
    $playable += $this->getTilesToPlayForValue($secondValue);

    if (empty($playable)) {
      return NULL;
    }

    $idx = array_rand($playable);
    unset($this->tiles[$idx]);
    return $playable[$idx];
  }

  /**
   * Gets a list of tiles which can be played for a given value.
   *
   * @param int $value
   *   The value to check against.
   *
   * @return \Dominoes\Tile[]
   *   The tiles which can be played.
   */
  private function getTilesToPlayForValue(int $value): array {
    return array_filter($this->tiles, function (Tile $tile) use ($value) {
      return $tile->canPlayForValue($value);
    });
  }

  /**
   * {@inheritdoc}
   */
  public function __toString(): string {
    return $this->name;
  }

}
