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
	
	protected function generateRandIntArray(int $count = 3, int $min = -100, $max = 100) : array {
		$arr = [];
		for($i = 0; $i < $count; $i++){
			$arr[] = mt_rand($min, $max);
		}
		return $arr;
	}

	public function minProvider() : \Generator{
		yield [
			new Vector3(0, mt_rand(0, 100), mt_rand(0, 100)),
			new Vector3(mt_rand(0, 100), 0, mt_rand(0, 100)),
			new Vector3(mt_rand(0, 100), mt_rand(0, 100), 0),
			new Vector3(0, 0, 0)
		];
		yield [
			new Vector3(mt_rand(0, 100), mt_rand(0, 100), 0),
			new Vector3(4, mt_rand(0, 100), mt_rand(0, 100)),
			new Vector3(mt_rand(0, 100), 2, mt_rand(0, 100)),
			new Vector3(4, 2, 0)
		];
		yield [
			new Vector3(1337, 256, 512),
			new Vector3(9, 9, 9),
			new Vector3(128, 256, 512),
			new Vector3(9, 9, 9)
		];
		$arrRandX = $this->generateRandIntArray();
		$minX = min($arrRandX);
		$arrRandY = $this->generateRandIntArray();
		$minY = min($arrRandY);
		$arrRandZ = $this->generateRandIntArray();
		$minZ = min($arrRandZ);
		yield [
			new Vector3($arrRandX[0], $arrRandY[0], $arrRandZ[0]),
			new Vector3($arrRandX[1], $arrRandY[1], $arrRandZ[1]),
			new Vector3($arrRandX[2], $arrRandY[2], $arrRandZ[2]),
			new Vector3($minX, $minY, $minZ)
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
			new Vector3(1000, mt_rand(0, 100), mt_rand(0, 100)),
			new Vector3(mt_rand(0, 100), 1000, mt_rand(0, 100)),
			new Vector3(mt_rand(0, 100), mt_rand(0, 100), 1000),
			new Vector3(1000, 1000, 1000)
		];
		yield [
			new Vector3(mt_rand(-100, 0), mt_rand(-100, 0), 0),
			new Vector3(4, mt_rand(-100, 0), mt_rand(-100, 0)),
			new Vector3(mt_rand(-100, 0), 2, mt_rand(-100, 0)),
			new Vector3(4, 2, 0)
		];
		yield [
			new Vector3(1337, 256, 512),
			new Vector3(9, 9, 9),
			new Vector3(128, 256, 512),
			new Vector3(1337, 256, 512)
		];
		$arrRandX = $this->generateRandIntArray();
		$maxX = max($arrRandX);
		$arrRandY = $this->generateRandIntArray();
		$maxY = max($arrRandY);
		$arrRandZ = $this->generateRandIntArray();
		$maxZ = max($arrRandZ);
		yield [
			new Vector3($arrRandX[0], $arrRandY[0], $arrRandZ[0]),
			new Vector3($arrRandX[1], $arrRandY[1], $arrRandZ[1]),
			new Vector3($arrRandX[2], $arrRandY[2], $arrRandZ[2]),
			new Vector3($maxX, $maxY, $maxZ)
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
