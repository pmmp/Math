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

/**
 * Math related classes, like matrices, bounding boxes and vector
 */
namespace pocketmine\math;

use function sqrt;

abstract class Math{

	/**
	 * @param float $n
	 *
	 * @return int
	 */
	public static function floorFloat($n) : int{
		$i = (int) $n;
		return $n >= $i ? $i : $i - 1;
	}

	/**
	 * @param float $n
	 *
	 * @return int
	 */
	public static function ceilFloat($n) : int{
		$i = (int) $n;
		return $n <= $i ? $i : $i + 1;
	}

	/**
	 * @param number $start
	 * @param number $end
	 * @param float $percent
	 *
	 * @return float
	 */
	public static function lerp($start, $end, float $percent) : float{
		if (0 > $percent or $percent > 1) {
			throw new \InvalidArgumentException("percentage $percent should have a value of 0 to 1");
		}
		return ($end - $start) * $percent + $start;
	}

	/**
	 * Solves a quadratic equation with the given coefficients and returns an array of up to two solutions.
	 *
	 * @param float $a
	 * @param float $b
	 * @param float $c
	 *
	 * @return float[]
	 */
	public static function solveQuadratic(float $a, float $b, float $c) : array{
		$discriminant = $b ** 2 - 4 * $a * $c;
		if($discriminant > 0){ //2 real roots
			$sqrtDiscriminant = sqrt($discriminant);
			return [
				(-$b + $sqrtDiscriminant) / (2 * $a),
				(-$b - $sqrtDiscriminant) / (2 * $a)
			];
		}elseif($discriminant == 0){ //1 real root
			return [
				-$b / (2 * $a)
			];
		}else{ //No real roots
			return [];
		}
	}
}
