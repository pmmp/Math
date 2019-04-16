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

class Vector3Test extends TestCase{
	
	public function minProvider() : \Generator{
		yield [
			new Vector3(1, 2, 3),
			new Vector3(9, 8, 7),
			new Vector3(3, 2, 1),
			new Vector3(1, 2, 1)
		];
		yield [
			new Vector3(1, 2, -3),
			new Vector3(9, -8, 7),
			new Vector3(-9, 2, 1),
			new Vector3(-9, -8, -3)
		];
		yield [
			new Vector3(1.23, 6.28, 18.84),
			new Vector3(3.14, 2.34, 9.42),
			new Vector3(6.28, 12.56, 3.45),
			new Vector3(1.23, 2.34, 3.45)
		];
		yield [
			new Vector3(-M_PI, M_PI ** 2, M_PI ** 3),
			new Vector3(M_PI, -(M_PI ** 2), 0),
			new Vector3(0, 0, -(M_PI ** 3)),
			new Vector3(-M_PI, -(M_PI ** 2), -(M_PI ** 3))
		];
	}

	/**
	 * @dataProvider minProvider
	 *
	 * @param Vector3 $vec1
	 * @param Vector3 $vec2
	 * @param Vector3 $vec3
	 * @param Vector3 $expected
	 */
	public function testMin(Vector3 $vec1, Vector3 $vec2, Vector3 $vec3, Vector3 $expected) : void{
		self::assertEquals(Vector3::min($vec1, $vec2, $vec3), $expected);
	}

	public function maxProvider() : \Generator{
		yield [
			new Vector3(1, 2, 3),
			new Vector3(9, 8, 7),
			new Vector3(3, 2, 1),
			new Vector3(9, 8, 7)
		];
		yield [
			new Vector3(1, 2, -3),
			new Vector3(9, -8, 7),
			new Vector3(-9, 2, 1),
			new Vector3(9, 2, 7)
		];
		yield [
			new Vector3(1.23, 6.28, 18.84),
			new Vector3(3.14, 2.34, 9.42),
			new Vector3(6.28, 12.56, 3.45),
			new Vector3(6.28, 12.56, 18.84)
		];
		yield [
			new Vector3(-M_PI, M_PI ** 2, M_PI ** 3),
			new Vector3(M_PI, -(M_PI ** 2), 0),
			new Vector3(0, 0, -(M_PI ** 3)),
			new Vector3(M_PI, M_PI ** 2, M_PI ** 3)
		];
	}

	/**
	 * @dataProvider maxProvider
	 *
	 * @param Vector3 $vec1
	 * @param Vector3 $vec2
	 * @param Vector3 $vec3
	 * @param Vector3 $expected
	 */
	public function testMax(Vector3 $vec1, Vector3 $vec2, Vector3 $vec3, Vector3 $expected) : void{
		self::assertEquals(Vector3::max($vec1, $vec2, $vec3), $expected);
	}
}
