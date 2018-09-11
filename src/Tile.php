<?php

namespace Dominoes;

/**
 * A domino tile (stone).
 */
class Tile {

  /**
   * First value of the tile.
   *
   * @var int
   */
  private $first;

  /**
   * Second value of the tile.
   *
   * @var int
   */
  private $second;

  /**
   * Constructor.
   *
   * @param int $first
   *   First value on the tile.
   * @param int $second
   *   Second value on the tile.
   * @param bool $isRotated
   *   Is the tile rotated?
   */
  public function __construct(int $first, int $second, bool $isRotated) {
    $this->first = $first;
    $this->second = $second;
    if ($isRotated) {
      $this->rotateTile();
    }
  }

  /**
   * Gets the first value.
   *
   * @return int
   *   First value.
   */
  public function getFirst(): int {
    return $this->first;
  }

  /**
   * Gets the second value.
   *
   * @return int
   *   Second value.
   */
  public function getSecond(): int {
    return $this->second;
  }

  /**
   * Rotate a tile.
   */
  public function rotateTile(): void {
    $tmp = $this->first;
    $this->first = $this->second;
    $this->second = $tmp;
  }

  /**
   * Can we play this tile for a given value?
   *
   * @param int $value
   *   The value to attach this tile to.
   *
   * @return bool
   *   TRUE when playable. FALSE otherwise.
   */
  public function canPlayForValue(int $value): bool {
    return $this->first === $value || $this->second === $value;
  }

  /**
   * {@inheritdoc}
   */
  public function __toString(): string {
    return "<{$this->first}:{$this->second}>";
  }

}
