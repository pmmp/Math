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

class Bearing{

	public const SOUTH = 0;
	public const WEST = 1;
	public const NORTH = 2;
	public const EAST = 3;

	/**
	 * Converts a 2D compass direction to a 3D axis direction.
	 *
	 * @param int $bearing
	 *
	 * @return int
	 */
	public static function toFacing(int $bearing) : int{
		switch($bearing){
			case self::NORTH:
				return Facing::NORTH;
			case self::SOUTH:
				return Facing::SOUTH;
			case self::WEST:
				return Facing::WEST;
			case self::EAST:
				return Facing::EAST;
			default:
				throw new \InvalidArgumentException("Unknown 2D direction $bearing");
		}
	}

	/**
	 * Converts a 3D axis direction to a 2D compass direction.
	 *
	 * @param int $facing
	 *
	 * @return int
	 */
	public static function fromFacing(int $facing) : int{
		switch($facing){
			case Facing::NORTH:
				return self::NORTH;
			case Facing::SOUTH:
				return self::SOUTH;
			case Facing::WEST:
				return self::WEST;
			case Facing::EAST:
				return self::EAST;
			default:
				throw new \InvalidArgumentException("Facing $facing does not have a corresponding 2D direction");
		}
	}

	public static function fromAngle(float $angle) : int{
		$angle %= 360;
		if($angle < 0){
			$angle += 360.0;
		}

		if((0 <= $angle and $angle < 45) or (315 <= $angle and $angle < 360)){
			return self::SOUTH;
		}
		if(45 <= $angle and $angle < 135){
			return self::WEST;
		}
		if(135 <= $angle and $angle < 225){
			return self::NORTH;
		}

		return self::EAST;
	}

	public static function rotate(int $bearing, int $step) : int{
		return ($bearing + $step) & 0x03;
	}

	public static function opposite(int $bearing) : int{
		return $bearing ^ 2;
	}
}
