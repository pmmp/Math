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

declare(strict_types=1);

namespace pocketmine\math\tests;


use PHPUnit\Framework\TestCase;

/**
 * Class for the Math class unit test
 */
class MathTest extends TestCase{

	public function testFloorFloat(){
		$this->assertSame(1, Math::floorFloat(1.2));
		$this->assertSame(-2, Math::floorFloat(-1.5));
	}

	public function testCeilFloat(){
		$this->assertSame(1, Math::ceilFloat(1.2));
		$this->assertSame(-1, Math::ceilFloat(-1.2));
	}

	public function solveQuadraticProvider(){
		return [
			[2, 3, 4, []],
			[1, 5, 4, [-1.0, -4.0]],
			[1, 0, 0, [0.0]],
		];
	}

	/**
	 * @dataProvider solveQuadraticProvider
	 */
	public function testSolveQuadratic($a, $b, $c, $expectedArray){
		$this->assertSame($expectedArray, Math::solveQuadratic($a, $b, $c));
	}

	public function testSolveQuadraticThrowsInvalidArgumentException(){
		$this->expectException(\InvalidArgumentException::class);
		$this->expectExceptionMessage('Division by zero');
		Math::solveQuadratic(0, 0, 0);
	}
}
