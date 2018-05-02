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


use pocketmine\math\VoxelRayTrace;
use pocketmine\math\Vector3;
use PHPUnit\Framework\TestCase;

/**
 * Class for the VoxelRayTrace abstract class unit test
 */
class VoxelRayTraceTest extends TestCase{

	public function testInDirection(){
		$result = VoxelRayTrace::inDirection(new Vector3(1.2, 1,4, 1.6), new Vector3(1.1, 1.2, 1.3), 1.2);

		$this->assertSame('Vector3(x=1,y=1,z=4)', (string) $result->current());
	}

	public function testInDirectionThrowsInvalidArgumentException(){
		$result = VoxelRayTrace::inDirection(new Vector3(0.0, 0.0, 0.0), new Vector3(0.0, 0.0, 0.0), 1.2);

		$this->expectException(\InvalidArgumentException::class);
		$this->expectExceptionMessage('Start and end points are the same, giving a zero direction vector');
		$this->assertSame('Vector3(x=1,y=1,z=4)', (string) $result->current());
	}
}