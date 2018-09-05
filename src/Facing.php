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

class Facing{

	public const AXIS_Y = 0;
	public const AXIS_Z = 1;
	public const AXIS_X = 2;

	public const FLAG_AXIS_POSITIVE = 1;

	/* most significant 2 bits = axis, least significant bit = is positive direction */
	public const DOWN =   self::AXIS_Y << 1;
	public const UP =    (self::AXIS_Y << 1) | self::FLAG_AXIS_POSITIVE;
	public const NORTH =  self::AXIS_Z << 1;
	public const SOUTH = (self::AXIS_Z << 1) | self::FLAG_AXIS_POSITIVE;
	public const WEST =   self::AXIS_X << 1;
	public const EAST =  (self::AXIS_X << 1) | self::FLAG_AXIS_POSITIVE;

	public const ALL = [
		self::DOWN,
		self::UP,
		self::NORTH,
		self::SOUTH,
		self::WEST,
		self::EAST
	];

	/**
	 * Returns the axis of the given direction.
	 *
	 * @param int $direction
	 *
	 * @return int
	 */
	public static function axis(int $direction) : int{
		return $direction >> 1; //shift off positive/negative bit
	}

	/**
	 * Returns whether the direction is facing the positive of its axis.
	 *
	 * @param int $direction
	 *
	 * @return bool
	 */
	public static function isPositive(int $direction) : bool{
		return ($direction & self::FLAG_AXIS_POSITIVE) === self::FLAG_AXIS_POSITIVE;
	}

	/**
	 * Returns the opposite Facing of the specified one.
	 *
	 * @param int $direction 0-5 one of the Facing::* constants
	 *
	 * @return int
	 */
	public static function opposite(int $direction) : int{
		return $direction ^ self::FLAG_AXIS_POSITIVE;
	}
}
