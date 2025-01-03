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

namespace pocketmine\math;

use function floatval;
use function floor;
use const INF;

final class VoxelRayTrace{
	private function __construct(){
		//NOOP
	}

	/**
	 * Performs a ray trace from the start position in the given direction, for a distance of $maxDistance. This
	 * returns a Generator which yields Vector3s containing the coordinates of voxels it passes through.
	 *
	 * @see VoxelRayTrace::betweenPoints for precise semantics
	 *
	 * @return \Generator|Vector3[]
	 * @phpstan-return \Generator<int, Vector3, void, void>
	 */
	public static function inDirection(Vector3 $start, Vector3 $directionVector, float $maxDistance) : \Generator{
		return self::betweenPoints($start, $start->addVector($directionVector->multiply($maxDistance)));
	}

	/**
	 * Performs a ray trace between the start and end coordinates. This returns a Generator which yields Vector3s
	 * containing the coordinates of voxels it passes through.
	 *
	 * The first Vector3 is `$start->floor()`.
	 * Every subsequent Vector3 has a taxicab distance of exactly 1 from the previous Vector3;
	 * if the ray crosses the intersection of multiple axis boundaries directly,
	 * the algorithm prefers crossing the boundaries in the order `Z -> Y -> X`.
	 *
	 * If `$end` is on an axis boundary, the final Vector3 may or may not cross that boundary.
	 * Otherwise, the final Vector3 is equal to `$end->floor()`.
	 *
	 * This is an implementation of the algorithm described in the link below.
	 * @link http://www.cse.yorku.ca/~amana/research/grid.pdf
	 *
	 * @return \Generator|Vector3[]
	 * @phpstan-return \Generator<int, Vector3, void, void>
	 *
	 * @throws \InvalidArgumentException if $start and $end have zero distance.
	 */
	public static function betweenPoints(Vector3 $start, Vector3 $end) : \Generator{
		$currentBlock = $start->floor();

		$directionVector = $end->subtractVector($start)->normalize();
		if($directionVector->lengthSquared() <= 0){
			throw new \InvalidArgumentException("Start and end points are the same, giving a zero direction vector");
		}

		$radius = $start->distance($end);

		$stepX = $directionVector->x <=> 0;
		$stepY = $directionVector->y <=> 0;
		$stepZ = $directionVector->z <=> 0;

		//Initialize the step accumulation variables depending how far into the current block the start position is. If
		//the start position is on the corner of the block, these will be zero.
		$tMaxX = self::distanceFactorToBoundary($start->x, $directionVector->x);
		$tMaxY = self::distanceFactorToBoundary($start->y, $directionVector->y);
		$tMaxZ = self::distanceFactorToBoundary($start->z, $directionVector->z);

		//The change in t on each axis when taking a step on that axis (always positive).
		$tDeltaX = floatval($directionVector->x) === 0.0 ? 0 : $stepX / $directionVector->x;
		$tDeltaY = floatval($directionVector->y) === 0.0 ? 0 : $stepY / $directionVector->y;
		$tDeltaZ = floatval($directionVector->z) === 0.0 ? 0 : $stepZ / $directionVector->z;

		while(true){
			yield $currentBlock;

			// tMaxX stores the t-value at which we cross a cube boundary along the
			// X axis, and similarly for Y and Z. Therefore, choosing the least tMax
			// chooses the closest cube boundary.
			if($tMaxX < $tMaxY and $tMaxX < $tMaxZ){
				if($tMaxX > $radius){
					break;
				}
				$currentBlock = $currentBlock->add($stepX, 0, 0);
				$tMaxX += $tDeltaX;
			}elseif($tMaxY < $tMaxZ){
				if($tMaxY > $radius){
					break;
				}
				$currentBlock = $currentBlock->add(0, $stepY, 0);
				$tMaxY += $tDeltaY;
			}else{
				if($tMaxZ > $radius){
					break;
				}
				$currentBlock = $currentBlock->add(0, 0, $stepZ);
				$tMaxZ += $tDeltaZ;
			}
		}
	}

	/**
	 * Used to decide which direction to move in first when beginning a ray trace.
	 *
	 * Examples:
	 * s=0.25, ds=0.5 -> 0.25 + 1.5(0.5) = 1 -> returns 1.5
	 * s=0.25, ds=-0.5 -> 0.25 + 0.5(-0.5) = 0 -> returns 0.5
	 * s=1 ds=0.5 -> 1 + 2(0.5) = 2 -> returns 2
	 * s=1 ds=-0.5 -> 1 + 0(-0.5) = 1 -> returns 0 (ds is negative and any subtraction will change 1 to 0.x)
	 *
	 * @param float $s Starting coordinate
	 * @param float $ds Direction vector component of the relevant axis
	 *
	 * @return float Number of times $ds must be added to $s to change its whole-number component.
	 */
	private static function distanceFactorToBoundary(float $s, float $ds) : float{
		if($ds === 0.0){
			return INF;
		}

		return $ds < 0 ?
			($s - floor($s)) / -$ds :
			(1 - ($s - floor($s))) / $ds;
	}
}
