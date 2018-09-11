<?php

namespace Tests\Dominoes;

use Dominoes\Player;
use Dominoes\Tile;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

/**
 * @coversDefaultClass \Dominoes\Player
 */
class PlayerTest extends TestCase {

  /**
   * The player.
   *
   * @var \Dominoes\Player
   */
  private $player;

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    $this->player = new Player('TestPlayer');
  }

  /**
   * @covers ::__construct
   */
  public function testConstructor() {
    $this->assertFalse($this->player->hasTiles());
  }

  /**
   * @covers ::addTiles
   * @covers ::hasTiles
   */
  public function testHasTiles() {
    $this->assertFalse($this->player->hasTiles());

    $t1 = new Tile(1, 2, FALSE);
    $this->player->addTiles([$t1]);

    $this->assertTrue($this->player->hasTiles());
  }

  /**
   * @covers ::getTilesToPlayForValue
   *
   * @dataProvider providerTilesToPlayForValue
   */
  public function testGetTilesToPlayForValue($tiles, $value, $expected) {
    $this->assertFalse($this->player->hasTiles(), "Player shouldn't have tiles to start with.");

    $this->player->addTiles($tiles);
    $method = $this->getHiddenMethod(Player::class, 'getTilesToPlayForValue');
    $this->assertSame($expected, $method->invoke($this->player, $value));
  }

  /**
   * @covers ::__toString
   */
  public function testToString() {
    $this->assertSame("TestPlayer", (string) $this->player);
  }

  /**
   * Data provider for testGetTilesToPlayForValue.
   *
   * @return array
   *   A list of { tiles for player, value to match, expected result }.
   */
  public function providerTilesToPlayForValue() {
    $t11 = new Tile(1, 1, FALSE);
    $t12 = new Tile(1, 2, FALSE);
    $t24 = new Tile(2, 4, FALSE);
    $t25 = new Tile(2, 5, FALSE);
    $t56 = new Tile(5, 6, FALSE);
    return [
      // No tiles, doesn't match.
      [[], 1, []],

      // One tile, doesn't match.
      [[$t25], 1, []],

      // One tile, match.
      [[$t11], 1, [$t11]],

      // Multiple tiles, all match.
      [[$t12, $t24, $t25], 2, [$t12, $t24, $t25]],

      // Multiple tiles, some match.
      [[$t12, $t24, $t56], 2, [$t12, $t24]],
    ];
  }

  /**
   * Gets a hidden method from a class.
   *
   * Used for invoking the private / protected method.
   *
   * @param string $className
   *   Name of the class.
   * @param string $methodName
   *   Name of the method to get.
   *
   * @return \ReflectionMethod
   *   Reference to the method.
   *
   * @throws \ReflectionException
   */
  private function getHiddenMethod($className, $methodName) {
    $reflector = new ReflectionClass($className);
    $method = $reflector->getMethod($methodName);
    $method->setAccessible(TRUE);
    return $method;
  }

}
