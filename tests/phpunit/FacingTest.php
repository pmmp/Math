<?php

/*
 *
 *  ____            _        _   __  __ _                  __  __ ____
 * |  _ \ ___   ___| | _____| |_|  \/  (_)_ __   ___      |  \/  |  _ \
 * | |_) / _ \ / __| |/ / _ \ __| |\/| | | '_ \ / _ \_____| |\/| | |_) |
 * |  __/ (_) | (__|   <  __/ |_| |  | | | | | |  __/_____| |  | |  __/
 * |_|   \___/ \___|_|\_\___|\__|_|  |_|_|_| |_|\___|     |_|  |_|_|
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author PocketMine Team
 * @link http://www.pocketmine.net/
 *
 *
*/

namespace pocketmine\math;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class FacingTest extends TestCase{

	public static function axisProvider() : \Generator{
		yield [Facing::DOWN, Axis::Y];
		yield [Facing::UP, Axis::Y];
		yield [Facing::NORTH, Axis::Z];
		yield [Facing::SOUTH, Axis::Z];
		yield [Facing::WEST, Axis::X];
		yield [Facing::EAST, Axis::X];
	}

  #[DataProvider("axisProvider")]
	public function testAxis(Facing $direction, Axis $axis) : void{
		self::assertEquals($axis, Facing::axis($direction));
	}

	public static function oppositeProvider() : \Generator{
		yield [Facing::DOWN, Facing::UP];
		yield [Facing::NORTH, Facing::SOUTH];
		yield [Facing::WEST, Facing::EAST];
	}

	#[DataProvider("oppositeProvider")]
	public function testOpposite(Facing $dir1, Facing $dir2) : void{
		self::assertEquals($dir2, Facing::opposite($dir1));
		self::assertEquals($dir1, Facing::opposite($dir2));
	}

	public static function positiveProvider() : \Generator{
		yield [Facing::DOWN, false];
		yield [Facing::UP, true];
		yield [Facing::NORTH, false];
		yield [Facing::SOUTH, true];
		yield [Facing::WEST, false];
		yield [Facing::EAST, true];
	}

	#[DataProvider("positiveProvider")]
	public function testIsPositive(Facing $facing, bool $positive) : void{
		self::assertEquals($positive, Facing::isPositive($facing));
	}

	public static function rotateProvider() : \Generator{
		yield [Facing::NORTH, Axis::Y, true, Facing::EAST];
		yield [Facing::EAST, Axis::Y, true, Facing::SOUTH];
		yield [Facing::SOUTH, Axis::Y, true, Facing::WEST];
		yield [Facing::WEST, Axis::Y, true, Facing::NORTH];

		yield [Facing::NORTH, Axis::Y, false, Facing::WEST];
		yield [Facing::WEST, Axis::Y, false, Facing::SOUTH];
		yield [Facing::SOUTH, Axis::Y, false, Facing::EAST];
		yield [Facing::EAST, Axis::Y, false, Facing::NORTH];


		yield [Facing::UP, Axis::Z, true, Facing::EAST];
		yield [Facing::EAST, Axis::Z, true, Facing::DOWN];
		yield [Facing::DOWN, Axis::Z, true, Facing::WEST];
		yield [Facing::WEST, Axis::Z, true, Facing::UP];

		yield [Facing::UP, Axis::Z, false, Facing::WEST];
		yield [Facing::WEST, Axis::Z, false, Facing::DOWN];
		yield [Facing::DOWN, Axis::Z, false, Facing::EAST];
		yield [Facing::EAST, Axis::Z, false, Facing::UP];


		yield [Facing::UP, Axis::X, true, Facing::NORTH];
		yield [Facing::NORTH, Axis::X, true, Facing::DOWN];
		yield [Facing::DOWN, Axis::X, true, Facing::SOUTH];
		yield [Facing::SOUTH, Axis::X, true, Facing::UP];

		yield [Facing::UP, Axis::X, false, Facing::SOUTH];
		yield [Facing::SOUTH, Axis::X, false, Facing::DOWN];
		yield [Facing::DOWN, Axis::X, false, Facing::NORTH];
		yield [Facing::NORTH, Axis::X, false, Facing::UP];
	}

	#[DataProvider("rotateProvider")]
	public function testRotate(Facing $direction, Axis $axis, bool $clockwise, Facing $expected) : void{
		self::assertEquals($expected, Facing::rotate($direction, $axis, $clockwise));
	}
}
