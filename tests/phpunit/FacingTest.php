<?php
/**
 * Created by PhpStorm.
 * User: Dylan Taylor
 * Date: 13/09/2018
 * Time: 18:45
 */

namespace pocketmine\math;

use PHPUnit\Framework\TestCase;

class FacingTest extends TestCase{

	public function axisProvider() : \Generator{
		yield [Facing::DOWN, Facing::AXIS_Y];
		yield [Facing::UP, Facing::AXIS_Y];
		yield [Facing::NORTH, Facing::AXIS_Z];
		yield [Facing::SOUTH, Facing::AXIS_Z];
		yield [Facing::WEST, Facing::AXIS_X];
		yield [Facing::EAST, Facing::AXIS_X];
	}

	/**
	 * @dataProvider axisProvider
	 *
	 * @param int $direction
	 * @param int $axis
	 */
	public function testAxis(int $direction, int $axis) : void{
		self::assertEquals($axis, Facing::axis($direction));
	}

	public function oppositeProvider() : \Generator{
		yield [Facing::DOWN, Facing::UP];
		yield [Facing::NORTH, Facing::SOUTH];
		yield [Facing::WEST, Facing::EAST];
	}

	/**
	 * @dataProvider oppositeProvider
	 *
	 * @param int $dir1
	 * @param int $dir2
	 */
	public function testOpposite(int $dir1, int $dir2) : void{
		self::assertEquals($dir2, Facing::opposite($dir1));
		self::assertEquals($dir1, Facing::opposite($dir2));
	}

	public function positiveProvider() : \Generator{
		yield [Facing::DOWN, false];
		yield [Facing::UP, true];
		yield [Facing::NORTH, false];
		yield [Facing::SOUTH, true];
		yield [Facing::WEST, false];
		yield [Facing::EAST, true];
	}

	/**
	 * @dataProvider positiveProvider
	 *
	 * @param int  $facing
	 * @param bool $positive
	 */
	public function testIsPositive(int $facing, bool $positive) : void{
		self::assertEquals($positive, Facing::isPositive($facing));
	}

	public function rotateProvider() : \Generator{
		yield [Facing::NORTH, Facing::AXIS_Y, true, Facing::EAST];
		yield [Facing::EAST, Facing::AXIS_Y, true, Facing::SOUTH];
		yield [Facing::SOUTH, Facing::AXIS_Y, true, Facing::WEST];
		yield [Facing::WEST, Facing::AXIS_Y, true, Facing::NORTH];

		yield [Facing::NORTH, Facing::AXIS_Y, false, Facing::WEST];
		yield [Facing::WEST, Facing::AXIS_Y, false, Facing::SOUTH];
		yield [Facing::SOUTH, Facing::AXIS_Y, false, Facing::EAST];
		yield [Facing::EAST, Facing::AXIS_Y, false, Facing::NORTH];


		yield [Facing::UP, Facing::AXIS_Z, true, Facing::EAST];
		yield [Facing::EAST, Facing::AXIS_Z, true, Facing::DOWN];
		yield [Facing::DOWN, Facing::AXIS_Z, true, Facing::WEST];
		yield [Facing::WEST, Facing::AXIS_Z, true, Facing::UP];

		yield [Facing::UP, Facing::AXIS_Z, false, Facing::WEST];
		yield [Facing::WEST, Facing::AXIS_Z, false, Facing::DOWN];
		yield [Facing::DOWN, Facing::AXIS_Z, false, Facing::EAST];
		yield [Facing::EAST, Facing::AXIS_Z, false, Facing::UP];


		yield [Facing::UP, Facing::AXIS_X, true, Facing::NORTH];
		yield [Facing::NORTH, Facing::AXIS_X, true, Facing::DOWN];
		yield [Facing::DOWN, Facing::AXIS_X, true, Facing::SOUTH];
		yield [Facing::SOUTH, Facing::AXIS_X, true, Facing::UP];

		yield [Facing::UP, Facing::AXIS_X, false, Facing::SOUTH];
		yield [Facing::SOUTH, Facing::AXIS_X, false, Facing::DOWN];
		yield [Facing::DOWN, Facing::AXIS_X, false, Facing::NORTH];
		yield [Facing::NORTH, Facing::AXIS_X, false, Facing::UP];
	}

	/**
	 * @dataProvider rotateProvider
	 *
	 * @param int  $direction
	 * @param int  $axis
	 * @param bool $clockwise
	 * @param int  $expected
	 */
	public function testRotate(int $direction, int $axis, bool $clockwise, int $expected) : void{
		self::assertEquals($expected, Facing::rotate($direction, $axis, $clockwise));
	}
}
