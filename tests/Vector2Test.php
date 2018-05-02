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


use pocketmine\math\Vector2;
use PHPUnit\Framework\TestCase;

/**
 * Class for the Vector2 class unit test
 */
class Vector2Test extends TestCase{

	public function testConstructor(){
		$vector2 = new Vector2(1.2, 1.5);

		$this->assertSame(1.2, $vector2->getX());
		$this->assertSame(1.5, $vector2->getY());
	}

	public function testGetFloorVector(){
		$vector2 = new Vector2(1.2, 1.5);

		$this->assertSame(1, $vector2->getFloorX());
		$this->assertSame(1, $vector2->getFloorY());
	}

	public function testAdd(){
		$vector2 = new Vector2(1.2, 1.5);
		$result = $vector2->add(1.2, 1.2);
		$resultOnVector = $vector2->add(new Vector2(1.2, 1.5));

		$this->assertSame(2.4, $result->getX());
		$this->assertSame(2.7, $result->getY());
		$this->assertSame(2.4, $resultOnVector->getX());
		$this->assertSame(3.0, $resultOnVector->getY());
	}

	public function testSubtract(){
		$vector2 = new Vector2(1.2, 1.5);
		$result = $vector2->subtract(1.2, 1.2);
		$resultOnVector = $vector2->subtract(new Vector2(1.2, 1.5));

		$this->assertSame(0.0, $result->getX());
		$this->assertSame(0.3, $result->getY());
		$this->assertSame(0.0, $resultOnVector->getX());
		$this->assertSame(0.0, $resultOnVector->getY());
	}

	public function testCeil(){
		$vector2 = new Vector2(1.2, 1.5);
		$result = $vector2->ceil();

		$this->assertSame(2.0, $result->getX());
		$this->assertSame(2.0, $result->getY());
	}

	public function testFloor(){
		$vector2 = new Vector2(1.2, 1.5);
		$result = $vector2->floor();

		$this->assertSame(1.0, $result->getX());
		$this->assertSame(1.0, $result->getY());
	}

	public function testRound(){
		$vector2 = new Vector2(1.2, 1.5);
		$result = $vector2->round();

		$this->assertSame(1.0, $result->getX());
		$this->assertSame(2.0, $result->getY());
	}

	public function testAbs(){
		$vector2 = new Vector2(-1.2, -1.5);
		$result = $vector2->abs();

		$this->assertSame(1.2, $result->getX());
		$this->assertSame(1.5, $result->getY());
	}

	public function testMultiply(){
		$vector2 = new Vector2(-1.2, -1.5);
		$result = $vector2->multiply(1.2);

		$this->assertSame(-1.44, $result->getX());
		$this->assertSame(-1.80, $result->getY());
	}

	public function testDivide(){
		$vector2 = new Vector2(-1.2, -1.5);
		$result = $vector2->divide(2);

		$this->assertSame(-0.6, $result->getX());
		$this->assertSame(-0.75, $result->getY());
	}

	public function testDistance(){
		$vector2 = new Vector2(1.2, 1.5);
		$result = $vector2->distance(0.2, 1.5);
		$resultOnVector = $vector2->distance(new Vector2(1.2, 0.5));

		$this->assertSame(1.0, $result);
		$this->assertSame(1.0, $resultOnVector);
	}

	public function testDistanceSquared(){
		$vector2 = new Vector2(1.2, 1.5);
		$result = $vector2->distanceSquared(0.2, 1.5);
		$resultOnVector = $vector2->distanceSquared(new Vector2(1.2, 0.5));

		$this->assertSame(1.0, $result);
		$this->assertSame(1.0, $resultOnVector);
	}

	public function testLength(){
		$vector2 = new Vector2(1.0, 0.0);

		$this->assertSame(1.0, $vector2->length());
	}

	public function testLengthSquared(){
		$vector2 = new Vector2(2.0, 1.0);

		$this->assertSame(5.0, $vector2->lengthSquared());
	}

	public function normalizeProvider(){
		return [
			[1.0, 0.0, 1.0, 0.0],
			[0.0, 0.0, 0.0, 0.0],
		];
	}

	/**
	 * @dataProvider normalizeProvider
	 */
	public function testNormalize($x, $y, $expectedValueX, $expectedValueY){
		$vector2 = new Vector2($x, $y);
		$result = $vector2->normalize();

		$this->assertSame($expectedValueX, $result->getX());
		$this->assertSame($expectedValueY, $result->getY());
	}

	public function testDot(){
		$vector2 = new Vector2(1.2, 1.3);
		$v = new Vector2(2.0, 3.0);

		$this->assertSame(6.3, $vector2->dot($v));
	}

	public function testToString(){
		$vector2 = new Vector2(1.2, 1.5);

		$this->assertSame('Vector2(x=1.2,y=1.5)', (string) $vector2);
	}
}
