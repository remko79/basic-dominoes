<?php

namespace Tests\Dominoes;

use Dominoes\Tile;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Dominoes\Tile
 */
class TileTest extends TestCase {

  /**
   * First tile to test (1, 3).
   *
   * @var \Dominoes\Tile
   */
  private $tile;

  /**
   * Second tile to test (2, 4) rotated.
   *
   * @var \Dominoes\Tile
   */
  private $rotatedTile;

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    $this->tile = new Tile(1, 3, FALSE);
    $this->rotatedTile = new Tile(2, 4, TRUE);
  }

  /**
   * @covers ::__construct
   * @covers ::getFirst
   * @covers ::getSecond
   */
  public function testConstructor() {
    $this->assertSame(1, $this->tile->getFirst());
    $this->assertSame(3, $this->tile->getSecond());

    $this->assertSame(4, $this->rotatedTile->getFirst());
    $this->assertSame(2, $this->rotatedTile->getSecond());
  }

  /**
   * @covers ::rotateTile
   */
  public function testRotateTile() {
    $this->tile->rotateTile();
    $this->assertSame(3, $this->tile->getFirst());
    $this->assertSame(1, $this->tile->getSecond());
  }

  /**
   * @covers ::canPlayForValue
   */
  public function testCanPlayForValue() {
    $this->assertFalse($this->tile->canPlayForValue(0));
    $this->assertTrue($this->tile->canPlayForValue(1));
    $this->assertFalse($this->tile->canPlayForValue(2));
    $this->assertTrue($this->tile->canPlayForValue(3));
    $this->assertFalse($this->tile->canPlayForValue(4));
    $this->assertFalse($this->tile->canPlayForValue(5));
    $this->assertFalse($this->tile->canPlayForValue(6));
  }

  /**
   * @covers ::__toString
   */
  public function testToString() {
    $this->assertSame("<1:3>", (string) $this->tile);
    $this->assertSame("<4:2>", (string) $this->rotatedTile);
  }

}
