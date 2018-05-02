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


use pocketmine\math\AxisAlignedBB;
use pocketmine\math\Vector2;
use pocketmine\math\Vector3;
use PHPUnit\Framework\TestCase;

/**
 * Class for the AxisAlignedBB class unit test
 */
class AxisAlignedBBTest extends TestCase{

	public function testConstructor(){
		$axis = new AxisAlignedBB(1.1, 1.2, 1.3, 2.1, 2.2, 2.3);

		$this->assertInstanceOf(AxisAlignedBB::class, $axis);
		$this->assertSame('AxisAlignedBB(1.1, 1.2, 1.3, 2.1, 2.2, 2.3)', (string) $axis);
	}

	public function testSetBounds(){
		$axis = new AxisAlignedBB(1.1, 1.2, 1.3, 2.1, 2.2, 2.3);

		$this->assertInstanceOf(AxisAlignedBB::class, $axis->setBounds(1.2, 1.3, 1.4, 2.5, 2.6, 2.7));
		$this->assertSame('AxisAlignedBB(1.2, 1.3, 1.4, 2.5, 2.6, 2.7)', (string) $axis);
	}

	public function addCoordProvider(){
		return [
			[-1.1, -1.2, -1.3, 'AxisAlignedBB(0, 0, 0, 2.1, 2.2, 2.3)'],
			[1.1, 1.2, 1.3, 'AxisAlignedBB(1.1, 1.2, 1.3, 3.2, 3.4, 3.6)'],
		];
	}

	/**
	 * @dataProvider addCoordProvider
	 */
	public function testAddCoord($x, $y, $z, $expectedValue){
		$axis = new AxisAlignedBB(1.1, 1.2, 1.3, 2.1, 2.2, 2.3);
		$result = $axis->addCoord($x, $y, $z);

		$this->assertInstanceOf(AxisAlignedBB::class, $result);
		$this->assertSame($expectedValue, (string) $result);
	}

	public function testGrow(){
		$axis = new AxisAlignedBB(1.1, 1.2, 1.3, 2.1, 2.2, 2.3);
		$result = $axis->grow(2.1, 2.2, 2.3);

		$this->assertInstanceOf(AxisAlignedBB::class, $result);
		$this->assertSame('AxisAlignedBB(-1, -1, -1, 4.2, 4.4, 4.6)', (string) $result);
	}

	public function testExpand(){
		$axis = new AxisAlignedBB(1.1, 1.2, 1.3, 2.1, 2.2, 2.3);
		$result = $axis->expand(2.1, 2.2, 2.3);

		$this->assertInstanceOf(AxisAlignedBB::class, $result);
		$this->assertSame('AxisAlignedBB(-1, -1, -1, 4.2, 4.4, 4.6)', (string) $result);
		$this->assertSame('AxisAlignedBB(-1, -1, -1, 4.2, 4.4, 4.6)', (string) $axis);
	}

	public function testOffset(){
		$axis = new AxisAlignedBB(1.1, 1.2, 1.3, 2.1, 2.2, 2.3);
		$result = $axis->offset(2.1, 2.2, 2.3);

		$this->assertInstanceOf(AxisAlignedBB::class, $result);
		$this->assertSame('AxisAlignedBB(3.2, 3.4, 3.6, 4.2, 4.4, 4.6)', (string) $result);
		$this->assertSame('AxisAlignedBB(3.2, 3.4, 3.6, 4.2, 4.4, 4.6)', (string) $axis);
	}

	public function testShrink(){
		$axis = new AxisAlignedBB(1.1, 1.2, 1.3, 2.1, 2.2, 2.3);
		$result = $axis->shrink(2.1, 2.2, 2.3);

		$this->assertInstanceOf(AxisAlignedBB::class, $result);
		$this->assertSame('AxisAlignedBB(3.2, 3.4, 3.6, 0, 0, 0)', (string) $result);
	}

	public function testContract(){
		$axis = new AxisAlignedBB(1.1, 1.2, 1.3, 2.1, 2.2, 2.3);
		$result = $axis->contract(2.1, 2.2, 2.3);

		$this->assertInstanceOf(AxisAlignedBB::class, $result);
		$this->assertSame('AxisAlignedBB(3.2, 3.4, 3.6, 0, 0, 0)', (string) $result);
		$this->assertSame('AxisAlignedBB(3.2, 3.4, 3.6, 0, 0, 0)', (string) $axis);
	}

	public function testSetBB(){
		$axis = new AxisAlignedBB(1.1, 1.2, 1.3, 2.1, 2.2, 2.3);
		$bb = new AxisAlignedBB(1.0, 1.1, 1.2, 2.0, 2.1, 2.2);
		$result = $axis->setBB($bb);

		$this->assertInstanceOf(AxisAlignedBB::class, $result);
		$this->assertSame('AxisAlignedBB(1, 1.1, 1.2, 2, 2.1, 2.2)', (string) $result);
		$this->assertSame('AxisAlignedBB(1, 1.1, 1.2, 2, 2.1, 2.2)', (string) $axis);
	}

	public function testGetOffsetBoundingBox(){
		$axis = new AxisAlignedBB(1.1, 1.2, 1.3, 2.1, 2.2, 2.3);
		$result = $axis->getOffsetBoundingBox(1.1, 1.2, 1.3);

		$this->assertInstanceOf(AxisAlignedBB::class, $result);
		$this->assertSame('AxisAlignedBB(2.2, 2.4, 2.6, 3.2, 3.4, 3.6)', (string) $result);
	}

	public function calculateXOffsetProvider(){
		return [
			[new AxisAlignedBB(1.1, 1.2, 1.3, 2.1, 2.2, 2.3), 1.1, 1.1],
			[new AxisAlignedBB(1.1, 1.2, 1.5, 2.1, 1.2, 2.3), 1.1, 1.1],
			[new AxisAlignedBB(1.1, 1.2, 1.5, 2.1, 1.2, 2.4), 1.1, 1.1],
			[new AxisAlignedBB(1.1, 2.1, 1.3, 2.1, 1.4, 1.3), 1.1, 1.1],
			[new AxisAlignedBB(1.1, 2.0, 1.3, 1.1, 1.4, 1.5), 1.1, 0.0],
			[new AxisAlignedBB(2.1, 2.0, 1.3, 1.1, 1.4, 1.5), -1.1, 0.0],
		];
	}

	/**
	 * @dataProvider calculateXOffsetProvider
	 */
	public function testCalculateXOffset($bb, $offsetX, $expectedValue){
		$axis = new AxisAlignedBB(1.1, 1.2, 1.3, 2.1, 2.2, 2.3);

		$this->assertSame($expectedValue, $axis->calculateXOffset($bb, $offsetX));
	}

	public function calculateYOffsetProvider(){
		return [
			[new AxisAlignedBB(1.1, 1.2, 1.3, 1.1, 2.2, 2.3), 1.1, 1.1],
			[new AxisAlignedBB(1.1, 1.2, 1.5, 2.1, 1.2, 2.3), 1.1, 0.0],
			[new AxisAlignedBB(1.1, 0.1, 2.3, 3.1, 2.2, 2.3), 1.1, 1.1],
			[new AxisAlignedBB(1.1, 2.2, 0.3, 3.1, 2.2, 1.4), -1.1, 0.0],
		];
	}

	/**
	 * @dataProvider calculateYOffsetProvider
	 */
	public function testCalculateYOffset($bb, $offsetY, $expectedValue){
		$axis = new AxisAlignedBB(1.1, 1.2, 1.3, 2.1, 2.2, 2.3);

		$this->assertSame($expectedValue, $axis->calculateYOffset($bb, $offsetY));
	}

	public function calculateZOffsetProvider(){
		return [
			[new AxisAlignedBB(1.1, 1.2, 1.3, 1.1, 2.2, 2.3), 1.1, 1.1],
			[new AxisAlignedBB(1.1, 1.1, 1.5, 2.1, 1.2, 2.3), 1.1, 1.1],
			[new AxisAlignedBB(1.1, 0.1, 2.3, 3.1, 2.2, 2.3), 1.1, 1.1],
			[new AxisAlignedBB(1.1, 0.1, 2.3, 3.1, 2.2, 1.3), 1.1, 0.0],
			[new AxisAlignedBB(1.1, 0.1, 2.3, 3.1, 2.2, 1.3), -1.1, 0.0],
		];
	}

	/**
	 * @dataProvider calculateZOffsetProvider
	 */
	public function testCalculateZOffset($bb, $offsetZ, $expectedValue){
		$axis = new AxisAlignedBB(1.1, 1.2, 1.3, 2.1, 2.2, 2.3);

		$this->assertSame($expectedValue, $axis->calculateZOffset($bb, $offsetZ));
	}

	public function intersectsWithProvider(){
		return [
			[new AxisAlignedBB(1.1, 1.2, 1.3, 1.5, 2.2, 2.3), 0.00001, true],
			[new AxisAlignedBB(1.1, 1.2, 1.3, 1.1, 2.2, 2.3), 1.1, false],
		];
	}

	/**
	 * @dataProvider intersectsWithProvider
	 */
	public function testIntersectsWith($bb, $epsilon, $expectedValue){
		$axis = new AxisAlignedBB(1.1, 1.2, 1.3, 2.1, 2.2, 2.3);

		$this->assertSame($expectedValue, $axis->intersectsWith($bb, $epsilon));
	}

	public function testGetApverageEdgeLength(){
		$axis = new AxisAlignedBB(1.1, 1.2, 1.3, 2.1, 2.2, 2.3);

		$this->assertSame(1.0, $axis->getAverageEdgeLength());
	}

	public function testIsVectorInside(){
		$axis = new AxisAlignedBB(1.1, 1.2, 1.3, 2.1, 2.2, 2.3);

		$this->assertFalse($axis->isVectorInside(new Vector3(1.1, 1.2, 1.3)));
		$this->assertFalse($axis->isVectorInside(new Vector3(1.5, 1.2, 1.3)));
		$this->assertFalse($axis->isVectorInside(new Vector3(1.5, 2.0, 1.3)));
		$this->assertTrue($axis->isVectorInside(new Vector3(1.5, 2.0, 1.4)));
	}

	public function testIsVectorInYZ(){
		$axis = new AxisAlignedBB(1.1, 1.2, 1.3, 2.1, 1.2, 1.3);

		$this->assertFalse($axis->isVectorInYZ(new Vector3(1.1, 0.2, 1.3)));
		$this->assertTrue($axis->isVectorInYZ(new Vector3(1.5, 1.2, 1.3)));
	}

	public function testIsVectorInXZ(){
		$axis = new AxisAlignedBB(1.1, 1.2, 1.3, 2.1, 1.2, 1.3);

		$this->assertFalse($axis->isVectorInXZ(new Vector3(0.2, 1.1, 1.3)));
		$this->assertTrue($axis->isVectorInXZ(new Vector3(1.2, 1.5, 1.3)));
	}

	public function testIsVectorInXY(){
		$axis = new AxisAlignedBB(1.1, 1.2, 1.3, 2.1, 1.2, 1.3);

		$this->assertFalse($axis->isVectorInXY(new Vector3(0.2, 1.1, 1.3)));
		$this->assertTrue($axis->isVectorInXY(new Vector3(2.1, 1.2, 1.5)));
	}

	public function calculateInterceptProvider(){
		return[
			[new Vector3(0.0, 1.3, 1.5), new Vector3(0.0, 0.3, 0.5)],
			[new Vector3(1.0, 2.3, -2.5), new Vector3(1.1, -2.3, -2.5)]
		];
	}

	/**
	 * @dataProvider calculateInterceptProvider
	 */
	public function testCalculateIntercept($pos1, $pos2){
		$axis = new AxisAlignedBB(1.1, 1.2, 1.3, 2.1, 1.2, 1.3);

		$this->assertNull($axis->calculateIntercept($pos1, $pos2));
	}

	public function testToString(){
		$axis = new AxisAlignedBB(1.1, 1.2, 1.3, 2.1, 2.2, 2.3);

		$this->assertSame('AxisAlignedBB(1.1, 1.2, 1.3, 2.1, 2.2, 2.3)', (string) $axis);
	}
}
