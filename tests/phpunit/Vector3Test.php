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
	
	public function minComponentsProvider() : \Generator{
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
	 * @dataProvider minComponentsProvider
	 *
	 * @param Vector3 $vec1
	 * @param Vector3 $vec2
	 * @param Vector3 $vec3
	 * @param Vector3 $expected
	 */
	public function testMinComponents(Vector3 $vec1, Vector3 $vec2, Vector3 $vec3, Vector3 $expected) : void{
		self::assertEquals(Vector3::minComponents($vec1, $vec2, $vec3), $expected);
	}

	public function maxComponentsProvider() : \Generator{
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
	 * @dataProvider maxComponentsProvider
	 *
	 * @param Vector3 $vec1
	 * @param Vector3 $vec2
	 * @param Vector3 $vec3
	 * @param Vector3 $expected
	 */
	public function testMaxComponents(Vector3 $vec1, Vector3 $vec2, Vector3 $vec3, Vector3 $expected) : void{
		self::assertEquals(Vector3::maxComponents($vec1, $vec2, $vec3), $expected);
	}

	/**
	 * @return \Generator|Vector3[][][]
	 * @phpstan-return \Generator<int, list<list<Vector3>>, void, void>
	 */
	public function sumProvider() : \Generator{
		yield [[
			new Vector3(1, 1, 1),
			new Vector3(-1, -1, -1)
		]];
	}

	/**
	 * @dataProvider sumProvider
	 *
	 * @param Vector3[] $vectors
	 */
	public function testSum(array $vectors) : void{
		$vec = new Vector3(0, 0, 0);
		foreach($vectors as $vector){
			$vec = $vec->addVector($vector);
		}
		$vec2 = Vector3::sum(...$vectors);
		self::assertLessThan(0.000001, abs($vec->x - $vec2->x));
		self::assertLessThan(0.000001, abs($vec->y - $vec2->y));
		self::assertLessThan(0.000001, abs($vec->z - $vec2->z));
	}

	/**
	 * @phpstan-return \Generator<int, array{Vector3, float|int|null, float|int|null, float|int|null, Vector3}, void, void>
	 */
	public function withComponentsProvider() : \Generator{
		yield [new Vector3(0, 0, 0), 1, 1, 1, new Vector3(1, 1, 1)];
		yield [new Vector3(0, 0, 0), null, 1, 1, new Vector3(0, 1, 1)];
		yield [new Vector3(0, 0, 0), 1, null, 1, new Vector3(1, 0, 1)];
		yield [new Vector3(0, 0, 0), 1, 1, null, new Vector3(1, 1, 0)];
		yield [new Vector3(0, 0, 0), null, null, null, new Vector3(0, 0, 0)];
	}

	/**
	 * @dataProvider withComponentsProvider
	 *
	 * @param float|int|null $x
	 * @param float|int|null $y
	 * @param float|int|null $z
	 */
	public function testWithComponents(Vector3 $original, $x, $y, $z, Vector3 $expected) : void{
		$actual = $original->withComponents($x, $y, $z);
		self::assertTrue($actual->equals($expected));
	}
}
