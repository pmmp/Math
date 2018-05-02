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


use pocketmine\math\RayTraceResult;
use pocketmine\math\AxisAlignedBB;
use pocketmine\math\Vector3;
use PHPUnit\Framework\TestCase;

/**
 * Class for the RayTraceResult class unit test
 */
class RayTraceResultTest extends TestCase{

	public function testConstructor(){
		$bb = new AxisAlignedBB(1.1, 1.2, 1.3, 2.1, 2.2, 2.3);
		$hitVector = new Vector3(1.2, 1.3, 1.5);
		$rayTraceResult = new RayTraceResult($bb, 1, $hitVector);

		$this->assertInstanceOf(RayTraceResult::class, $rayTraceResult);
	}

	public function testGetBoundingBox(){
		$bb = new AxisAlignedBB(1.1, 1.2, 1.3, 2.1, 2.2, 2.3);
		$hitVector = new Vector3(1.2, 1.3, 1.5);
		$rayTraceResult = new RayTraceResult($bb, 1, $hitVector);

		$this->assertSame('AxisAlignedBB(1.1, 1.2, 1.3, 2.1, 2.2, 2.3)', (string) $rayTraceResult->getBoundingBox());
	}

	public function testGetHitFace(){
		$bb = new AxisAlignedBB(1.1, 1.2, 1.3, 2.1, 2.2, 2.3);
		$hitVector = new Vector3(1.2, 1.3, 1.5);
		$rayTraceResult = new RayTraceResult($bb, 1, $hitVector);

		$this->assertSame(1, $rayTraceResult->getHitFace());
	}

	public function testGetHitVector(){
		$bb = new AxisAlignedBB(1.1, 1.2, 1.3, 2.1, 2.2, 2.3);
		$hitVector = new Vector3(1.2, 1.3, 1.5);
		$rayTraceResult = new RayTraceResult($bb, 1, $hitVector);

		$this->assertSame(1.2, $rayTraceResult->getHitVector()->getX());
		$this->assertSame(1.3, $rayTraceResult->getHitVector()->getY());
		$this->assertSame(1.5, $rayTraceResult->getHitVector()->getZ());
	}
}
