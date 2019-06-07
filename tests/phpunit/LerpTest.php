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

use PHPUnit\Framework\TestCase;

class LerpTest extends TestCase{

	public function someLengthProvider() : \Generator{
		yield [
			1,
			10,
			0.1,
			1.9
		];
		yield [
			-1.5,
			5.0,
			0.5,
			1.75
		];
		yield [
			0,
			M_PI,
			0.25,
			M_PI_4
		];
	}

	/**
	 * @dataProvider someLengthProvider
	 *
	 * @param $start
	 * @param $end
	 * @param float $percent
	 * @param float $expected
	 */
	public function testLengthLeap($start, $end, float $percent, float $expected) {
		self::assertEquals(Math::lerp($start, $end, $percent), $expected);
	}

	public function someVector2Provider() : \Generator{
		yield [
			new Vector2(),
			new Vector2(128, 128),
			0.5,
			new Vector2(64, 64)
		];
		yield [
			new Vector2(-1.024, 2.048),
			new Vector2(10.24, -1.024),
			0.8,
			new Vector2(7.9872, -0.4096)
		];
	}

	/**
	 * @dataProvider someVector2Provider
	 *
	 * @param Vector2 $start
	 * @param Vector2 $end
	 * @param float $percent
	 * @param Vector2 $expected
	 */
	public function testVector2Leap(Vector2 $start, Vector2 $end, float $percent, Vector2 $expected) {
		self::assertEquals(Vector2::lerp($start, $end, $percent), $expected);
	}

	public function someVector3Provider() : \Generator{
		yield [
			new Vector3(123, 456, 789),
			new Vector3(987, 654, 321),
			0.75,
			new Vector3(771, 604.5, 438)
		];
		yield [
			new Vector3(0.246, 0.135, 0.879),
			new Vector3(13.57, 24.68, 99.99),
			0.3,
			new Vector3(4.2432, 7.4985, 30.6123)
		];
	}

	/**
	 * @dataProvider someVector3Provider
	 *
	 * @param Vector3 $start
	 * @param Vector3 $end
	 * @param float $percent
	 * @param Vector3 $expected
	 */
	public function testVector3Leap(Vector3 $start, Vector3 $end, float $percent, Vector3 $expected) {
		self::assertEquals(Vector3::lerp($start, $end, $percent), $expected);
	}

}
