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

use function in_array;

final class Facing{
	private function __construct(){
		//NOOP
	}

	public const FLAG_AXIS_POSITIVE = 1;

	/* most significant 2 bits = axis, least significant bit = is positive direction */
	public const DOWN =   Axis::Y << 1;
	public const UP =    (Axis::Y << 1) | self::FLAG_AXIS_POSITIVE;
	public const NORTH =  Axis::Z << 1;
	public const SOUTH = (Axis::Z << 1) | self::FLAG_AXIS_POSITIVE;
	public const WEST =   Axis::X << 1;
	public const EAST =  (Axis::X << 1) | self::FLAG_AXIS_POSITIVE;

	public const ALL = [
		self::DOWN,
		self::UP,
		self::NORTH,
		self::SOUTH,
		self::WEST,
		self::EAST
	];

	public const HORIZONTAL = [
		self::NORTH,
		self::SOUTH,
		self::WEST,
		self::EAST
	];

	public const OFFSET = [
		self::DOWN  => [ 0, -1,  0],
		self::UP    => [ 0, +1,  0],
		self::NORTH => [ 0,  0, -1],
		self::SOUTH => [ 0,  0, +1],
		self::WEST  => [-1,  0,  0],
		self::EAST  => [+1,  0,  0]
	];

	private const CLOCKWISE = [
		Axis::Y => [
			self::NORTH => self::EAST,
			self::EAST => self::SOUTH,
			self::SOUTH => self::WEST,
			self::WEST => self::NORTH
		],
		Axis::Z => [
			self::UP => self::EAST,
			self::EAST => self::DOWN,
			self::DOWN => self::WEST,
			self::WEST => self::UP
		],
		Axis::X => [
			self::UP => self::NORTH,
			self::NORTH => self::DOWN,
			self::DOWN => self::SOUTH,
			self::SOUTH => self::UP
		]
	];

	/**
	 * Returns the axis of the given direction.
	 */
	public static function axis(int $direction) : int{
		return $direction >> 1; //shift off positive/negative bit
	}

	/**
	 * Returns whether the direction is facing the positive of its axis.
	 */
	public static function isPositive(int $direction) : bool{
		return ($direction & self::FLAG_AXIS_POSITIVE) === self::FLAG_AXIS_POSITIVE;
	}

	/**
	 * Returns the opposite Facing of the specified one.
	 *
	 * @param int $direction 0-5 one of the Facing::* constants
	 */
	public static function opposite(int $direction) : int{
		return $direction ^ self::FLAG_AXIS_POSITIVE;
	}

	/**
	 * Rotates the given direction around the axis.
	 *
	 * @throws \InvalidArgumentException if not possible to rotate $direction around $axis
	 */
	public static function rotate(int $direction, int $axis, bool $clockwise) : int{
		if(!isset(self::CLOCKWISE[$axis])){
			throw new \InvalidArgumentException("Invalid axis $axis");
		}
		if(!isset(self::CLOCKWISE[$axis][$direction])){
			throw new \InvalidArgumentException("Cannot rotate facing \"" . self::toString($direction) . "\" around axis \"" . Axis::toString($axis) . "\"");
		}

		$rotated = self::CLOCKWISE[$axis][$direction];
		return $clockwise ? $rotated : self::opposite($rotated);
	}

	/**
	 * @throws \InvalidArgumentException
	 */
	public static function rotateY(int $direction, bool $clockwise) : int{
		return self::rotate($direction, Axis::Y, $clockwise);
	}

	/**
	 * @throws \InvalidArgumentException
	 */
	public static function rotateZ(int $direction, bool $clockwise) : int{
		return self::rotate($direction, Axis::Z, $clockwise);
	}

	/**
	 * @throws \InvalidArgumentException
	 */
	public static function rotateX(int $direction, bool $clockwise) : int{
		return self::rotate($direction, Axis::X, $clockwise);
	}

	/**
	 * Validates the given integer as a Facing direction.
	 *
	 * @throws \InvalidArgumentException if the argument is not a valid Facing constant
	 */
	public static function validate(int $facing) : void{
		if(!in_array($facing, self::ALL, true)){
			throw new \InvalidArgumentException("Invalid direction $facing");
		}
	}

	/**
	 * Returns a human-readable string representation of the given Facing direction.
	 */
	public static function toString(int $facing) : string{
		return match($facing){
			self::DOWN => "down",
			self::UP => "up",
			self::NORTH => "north",
			self::SOUTH => "south",
			self::WEST => "west",
			self::EAST => "east",
			default => throw new \InvalidArgumentException("Invalid facing $facing")
		};
	}
}
