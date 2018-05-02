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
use pocketmine\math\Vector3;
use PHPUnit\Framework\TestCase;

/**
 * Class for the Vector3 class unit test
 */
class Vector3Test extends TestCase{

	public function testConstructor(){
		$vector3 = new Vector3(1.2, 1.5, 1.3);

		$this->assertSame(1.2, $vector3->getX());
		$this->assertSame(1.5, $vector3->getY());
		$this->assertSame(1.3, $vector3->getZ());
	}

	public function testGetFloorVector(){
		$vector3 = new Vector3(1.2, 1.5, 1.3);

		$this->assertSame(1, $vector3->getFloorX());
		$this->assertSame(1, $vector3->getFloorY());
		$this->assertSame(1, $vector3->getFloorZ());
	}

	public function testAdd(){
		$vector3 = new Vector3(1.2, 1.5, 1.3);
		$result = $vector3->add(1.2, 1.2, 1.3);
		$resultOnVector = $vector3->add(new Vector3(1.2, 1.5));

		$this->assertSame(2.4, $result->getX());
		$this->assertSame(2.7, $result->getY());
		$this->assertSame(2.6, $result->getZ());
		$this->assertSame(2.4, $resultOnVector->getX());
		$this->assertSame(3.0, $resultOnVector->getY());
		$this->assertSame(1.3, $resultOnVector->getZ());
	}

	public function testSubtract(){
		$vector3 = new Vector3(1.2, 1.5, 1.3);
		$result = $vector3->subtract(1.2, 1.2, 1.2);
		$resultOnVector = $vector3->subtract(new Vector3(1.2, 1.5));

		$this->assertSame(0.0, $result->getX());
		$this->assertSame(0.3, $result->getY());
		$this->assertSame(0.1, $result->getZ());
		$this->assertSame(0.0, $resultOnVector->getX());
		$this->assertSame(0.0, $resultOnVector->getY());
		$this->assertSame(1.3, $resultOnVector->getZ());
	}

	public function testCeil(){
		$vector3 = new Vector3(1.2, 1.5, 1.3);
		$result = $vector3->ceil();

		$this->assertSame(2, $result->getX());
		$this->assertSame(2, $result->getY());
		$this->assertSame(2, $result->getZ());
	}

	public function testFloor(){
		$vector3 = new Vector3(1.2, 1.5, 1.3);
		$result = $vector3->floor();

		$this->assertSame(1, $result->getX());
		$this->assertSame(1, $result->getY());
		$this->assertSame(1, $result->getZ());
	}

	public function testRound(){
		$vector3 = new Vector3(1.2, 1.5, 1.3);
		$result = $vector3->round();
		$resultOnPrecision = $vector3->round(1);

		$this->assertSame(1, $result->getX());
		$this->assertSame(2, $result->getY());
		$this->assertSame(1, $result->getZ());
		$this->assertSame(1.2, $resultOnPrecision->getX());
		$this->assertSame(1.5, $resultOnPrecision->getY());
		$this->assertSame(1.3, $resultOnPrecision->getZ());
	}

	public function testAbs(){
		$vector3 = new Vector3(-1.2, -1.5, 1.3);
		$result = $vector3->abs();

		$this->assertSame(1.2, $result->getX());
		$this->assertSame(1.5, $result->getY());
		$this->assertSame(1.3, $result->getZ());
	}

	public function getSideProvider(){
		return [
			[0, 1, -1.2, -2.5, 1.3],
			[1, 1, -1.2, -0.5, 1.3],
			[2, 1, -1.2, -1.5, 0.3],
			[3, 1, -1.2, -1.5, 2.3],
			[4, 1, -2.2, -1.5, 1.3],
			[5, 1, -0.2, -1.5, 1.3],
		];
	}

	/**
	 * @dataProvider getSideProvider
	 */
	public function testGetSide($side, $step, $expectedValueX, $expectedValueY, $expectedValueZ){
		$vector3 = new Vector3(-1.2, -1.5, 1.3);
		$result = $vector3->getSide($side, $step);

		$this->assertSame($expectedValueX, $result->getX());
		$this->assertSame($expectedValueY, $result->getY());
		$this->assertSame($expectedValueZ, $result->getZ());
	}

	public function testGetSideOnInvalidSide(){
		$vector3 = new Vector3(-1.2, -1.5, 1.3);

		$this->assertInstanceOf(Vector3::class, $vector3->getSide(6));
	}

	public function testAsVector3(){
		$vector3 = new Vector3(-1.2, -1.5, 1.3);
		$asVector3 = $vector3->asVector3();

		$this->assertInstanceOf(Vector3::class, $asVector3);
		$this->assertSame(-1.2, $asVector3->getX());
		$this->assertSame(-1.5, $asVector3->getY());
		$this->assertSame(1.3, $asVector3->getZ());
	}

	public function testGetOppositeSide(){
		$vector3 = new Vector3(-1.2, -1.5, 1.3);
		$getOppositeResult = $vector3->getOppositeSide(0);

		$this->assertSame(1, $getOppositeResult);
	}

	public function testGetOppositeSideOnInvalidSide(){
		$vector3 = new Vector3(-1.2, -1.5, 1.3);

		$this->expectException(\InvalidArgumentException::class);
		$this->expectExceptionMessage('Invalid side 6 given to getOppositeSide');
		$getOppositeResult = $vector3->getOppositeSide(6);
	}

	public function testMultiply(){
		$vector3 = new Vector3(-1.2, -1.5, 1.3);
		$result = $vector3->multiply(1.2);

		$this->assertSame(-1.44, $result->getX());
		$this->assertSame(-1.80, $result->getY());
		$this->assertSame(1.56, $result->getZ());
	}

	public function testDivide(){
		$vector3 = new Vector3(-1.2, -1.5, 1.3);
		$result = $vector3->divide(2);

		$this->assertSame(-0.6, $result->getX());
		$this->assertSame(-0.75, $result->getY());
		$this->assertSame(0.65, $result->getZ());
	}

	public function testDistance(){
		$vector3 = new Vector3(1.2, 1.5, 2.3);
		$result = $vector3->distance(new Vector3(1.2, 1.5, 0.3));

		$this->assertSame(2.0, $result);
	}

	public function testDistanceSquared(){
		$vector3 = new Vector3(1.2, 1.5, 2.3);
		$result = $vector3->distanceSquared(new Vector3(1.2, 1.5, 0.3));

		$this->assertSame(4.0, $result);
	}

	public function maxPlainDistanceProvider(){
		return [
			[new Vector3(1.1, 1.2, 1.3), 0.2, 0.2],
			[new Vector2(1.2, 1.3), 0, 0.2],
		];
	}

	/**
	 * @dataProvider maxPlainDistanceProvider
	 */
	public function testMaxPlainDistance($vector, $z, $expectedValue){
		$vector3 = new Vector3(1.2, 1.3, 1.5);

		$this->assertSame($expectedValue, $vector3->maxPlainDistance($vector, $z));
	}

	public function testLength(){
		$vector3 = new Vector3(1.0, 0.0, 0.0);

		$this->assertSame(1.0, $vector3->length());
	}

	public function testLengthSquared(){
		$vector3 = new Vector3(1.2, 1.3, 1.5);

		$this->assertSame(5.38, $vector3->lengthSquared());
	}

	public function normalizeProvider(){
		return [
			[1.0, 0.0, 0.0, 1.0, 0.0, 0.0],
			[0, 0, 0, 0, 0, 0],
		];
	}

	/**
	 * @dataProvider normalizeProvider
	 */
	public function testNormalize($x, $y, $z, $expectedValueX, $expectedValueY, $expectedValueZ){
		$vector3 = new Vector3($x, $y);
		$result = $vector3->normalize();

		$this->assertSame($expectedValueX, $result->getX());
		$this->assertSame($expectedValueY, $result->getY());
		$this->assertSame($expectedValueZ, $result->getZ());
	}

	public function testDot(){
		$vector3 = new Vector3(1.2, 1.3, 1.5);
		$v = new Vector3(2.0, 3.0, 4.0);

		$this->assertSame(12.3, $vector3->dot($v));
	}

	public function testCross(){
		$vector3 = new Vector3(1.2, 1.3, 1.5);
		$v = new Vector3(2.0, 3.0, 4.0);
		$result = $vector3->cross($v);

		$this->assertSame(0.7, $result->getX());
		$this->assertSame(-1.8, $result->getY());
		$this->assertSame(1.0, $result->getZ());
	}

	public function testEquals(){
		$vector3 = new Vector3(1.2, 1.3, 1.5);
		$v1 = new Vector3(1.2, 1.3, 1.5);
		$v2 = new Vector3(1.2, 1.3, 1.6);

		$this->assertTrue($vector3->equals($v1));
		$this->assertFalse($vector3->equals($v2));
	}

	public function testGetIntermediateWithXValue(){
		$vector3 = new Vector3(0.0, 1.3, 1.5);
		$v1 = new Vector3(0.00000001, 1.2, 1.3);
		$v2 = new Vector3(1.1, 1.2, 1.3);
		$result = $vector3->getIntermediateWithXValue($v2, 0.0);

		$this->assertNull($vector3->getIntermediateWithXValue($v1, 0.0));
		$this->assertNull($vector3->getIntermediateWithXValue($v2, -10.0));
		$this->assertSame(0.0, $result->getX());
		$this->assertSame(1.3, $result->getY());
		$this->assertSame(1.5, $result->getZ());
	}

	public function testGetIntermediateWithYValue(){
		$vector3 = new Vector3(1.2, 0.0, 1.5);
		$v1 = new Vector3(1.2, 0.00000001, 1.3);
		$v2 = new Vector3(1.1, 1.2, 1.3);
		$result = $vector3->getIntermediateWithYValue($v2, 0.0);

		$this->assertNull($vector3->getIntermediateWithYValue($v1, 0.0));
		$this->assertNull($vector3->getIntermediateWithYValue($v2, -10.0));
		$this->assertSame(1.2, $result->getX());
		$this->assertSame(0.0, $result->getY());
		$this->assertSame(1.5, $result->getZ());
	}

	public function testGetIntermediateWithZValue(){
		$vector3 = new Vector3(1.2, 1.5, 0.0);
		$v1 = new Vector3(1.2, 1.3, 0.00000001);
		$v2 = new Vector3(1.1, 1.2, 1.3);
		$result = $vector3->getIntermediateWithZValue($v2, 0.0);

		$this->assertNull($vector3->getIntermediateWithZValue($v1, 0.0));
		$this->assertNull($vector3->getIntermediateWithZValue($v2, -10.0));
		$this->assertSame(1.2, $result->getX());
		$this->assertSame(1.5, $result->getY());
		$this->assertSame(0.0, $result->getZ());
	}

	public function testSetComponents(){
		$vector3 = new Vector3(1.2, 1.3, 1.5);
		$result = $vector3->setComponents(1.1, 1.2, 1.3);

		$this->assertInstanceOf(Vector3::class, $result);
		$this->assertSame(1.1, $result->getX());
		$this->assertSame(1.2, $result->getY());
		$this->assertSame(1.3, $result->getZ());
	}

	public function testToString(){
		$vector3 = new Vector3(1.2, 1.3, 1.5);

		$this->assertSame('Vector3(x=1.2,y=1.3,z=1.5)', (string) $vector3);
	}
}
