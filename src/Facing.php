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

enum Facing: int{

	private const FLAG_AXIS_POSITIVE = 1;

	/* most significant 2 bits = axis, least significant bit = is positive direction */
	case DOWN =   Axis::Y << 1;
	case UP =    (Axis::Y << 1) | self::FLAG_AXIS_POSITIVE;
	case NORTH =  Axis::Z << 1;
	case SOUTH = (Axis::Z << 1) | self::FLAG_AXIS_POSITIVE;
	case WEST =   Axis::X << 1;
	case EAST =  (Axis::X << 1) | self::FLAG_AXIS_POSITIVE;

	/**
	 * @deprecated use Facing::cases()
	 */
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

	/**
	 * @deprecated
	 */
	public const OFFSET = [
		self::DOWN  => [ 0, -1,  0],
		self::UP    => [ 0, +1,  0],
		self::NORTH => [ 0,  0, -1],
		self::SOUTH => [ 0,  0, +1],
		self::WEST  => [-1,  0,  0],
		self::EAST  => [+1,  0,  0]
	];

	/** 
	 * @var Facing[][]
	 */
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
	public static function axis(Facing $direction) : Axis{
		return Axis::from($direction >> 1); //shift off positive/negative bit
	}

	/**
	 * Returns whether the direction is facing the positive of its axis.
	 */
	public static function isPositive(Facing $direction) : bool{
		return ($direction->value & self::FLAG_AXIS_POSITIVE) === self::FLAG_AXIS_POSITIVE;
	}

	/**
	 * Returns the opposite Facing of the specified one.
	 *
	 * @throws \ValueError if opposite facing don't exist
	 */
	public static function opposite(Facing $direction) : Facing{
		return self::from($direction->value ^ self::FLAG_AXIS_POSITIVE);
	}

	/**
	 * Rotates the given direction around the axis.
	 */
	public static function rotate(Facing $direction, Axis $axis, bool $clockwise) : Facing{
		$rotated = self::CLOCKWISE[$axis->value][$direction->value];
		return $clockwise ? $rotated : self::opposite($rotated);
	}

	public static function rotateY(Facing $direction, bool $clockwise) : Facing{
		return self::rotate($direction, Axis::Y, $clockwise);
	}

	public static function rotateZ(Facing $direction, bool $clockwise) : Facing{
		return self::rotate($direction, Axis::Z, $clockwise);
	}

	public static function rotateX(Facing $direction, bool $clockwise) : Facing{
		return self::rotate($direction, Axis::X, $clockwise);
	}

	public function offset(): array {
		return match($this){
			self::DOWN  => [ 0, -1,  0],
			self::UP    => [ 0, +1,  0],
			self::NORTH => [ 0,  0, -1],
			self::SOUTH => [ 0,  0, +1],
			self::WEST  => [-1,  0,  0],
			self::EAST  => [+1,  0,  0]
		};
	}

	/**
	 * Validates the given integer as a Facing direction.
	 * @deprecated 
	 * @throws \InvalidArgumentException if the argument is not a valid Facing constant
	 */
	public static function validate(int $facing) : void{
		if(!in_array($facing, self::ALL, true)){
			throw new \InvalidArgumentException("Invalid direction $facing");
		}
	}

	/**
	 * @deprecated use Facing->name
	 * Returns a human-readable string representation of the given Facing direction.
	 */
	public static function toString(Facing $facing) : string{
		return match($facing){
			self::DOWN => "down",
			self::UP => "up",
			self::NORTH => "north",
			self::SOUTH => "south",
			self::WEST => "west",
			self::EAST => "east",
		};
	}
}