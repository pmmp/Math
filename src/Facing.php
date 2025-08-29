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

use function strtolower;

enum Facing : int{
	public const FLAG_AXIS_POSITIVE = 1;

	/* most significant 2 bits = axis, least significant bit = is positive direction */
	case DOWN =   Axis::Y->value << 1;
	case UP =    (Axis::Y->value << 1) | self::FLAG_AXIS_POSITIVE;
	case NORTH =  Axis::Z->value << 1;
	case SOUTH = (Axis::Z->value << 1) | self::FLAG_AXIS_POSITIVE;
	case WEST =   Axis::X->value << 1;
	case EAST =  (Axis::X->value << 1) | self::FLAG_AXIS_POSITIVE;

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
		self::DOWN->value  => [ 0, -1,  0],
		self::UP->value    => [ 0, +1,  0],
		self::NORTH->value => [ 0,  0, -1],
		self::SOUTH->value => [ 0,  0, +1],
		self::WEST->value  => [-1,  0,  0],
		self::EAST->value  => [+1,  0,  0]
	];

	private const CLOCKWISE = [
		Axis::Y->value => [
			self::NORTH->value => self::EAST,
			self::EAST->value => self::SOUTH,
			self::SOUTH->value => self::WEST,
			self::WEST->value => self::NORTH
		],
		Axis::Z->value => [
			self::UP->value => self::EAST,
			self::EAST->value => self::DOWN,
			self::DOWN->value => self::WEST,
			self::WEST->value => self::UP
		],
		Axis::X->value => [
			self::UP->value => self::NORTH,
			self::NORTH->value => self::DOWN,
			self::DOWN->value => self::SOUTH,
			self::SOUTH->value => self::UP
		]
	];

	/**
	 * Returns the axis of the given direction.
	 */
	public static function axis(Facing $direction) : Axis{
		return Axis::from($direction->value >> 1); //shift off positive/negative bit
	}

	/**
	 * Returns whether the direction is facing the positive of its axis.
	 */
	public static function isPositive(Facing $direction) : bool{
		return ($direction->value & self::FLAG_AXIS_POSITIVE) === self::FLAG_AXIS_POSITIVE;
	}

	/**
	 * Returns the opposite Facing of the specified one.
	 */
	public static function opposite(Facing $direction) : Facing{
		return self::from($direction->value ^ self::FLAG_AXIS_POSITIVE);
	}

	/**
	 * Rotates the given direction around the axis.
	 *
	 * @throws \InvalidArgumentException if not possible to rotate $direction around $axis
	 */
	public static function rotate(Facing $direction, Axis $axis, bool $clockwise) : Facing{
		if(!isset(self::CLOCKWISE[$axis->value][$direction->value])){
			throw new \InvalidArgumentException("Cannot rotate facing \"" . self::toString($direction) . "\" around axis \"" . Axis::toString($axis) . "\"");
		}

		$rotated = self::CLOCKWISE[$axis->value][$direction->value];
		return $clockwise ? $rotated : self::opposite($rotated);
	}

	/**
	 * @throws \InvalidArgumentException
	 */
	public static function rotateY(Facing $direction, bool $clockwise) : Facing{
		return self::rotate($direction, Axis::Y, $clockwise);
	}

	/**
	 * @throws \InvalidArgumentException
	 */
	public static function rotateZ(Facing $direction, bool $clockwise) : Facing{
		return self::rotate($direction, Axis::Z, $clockwise);
	}

	/**
	 * @throws \InvalidArgumentException
	 */
	public static function rotateX(Facing $direction, bool $clockwise) : Facing{
		return self::rotate($direction, Axis::X, $clockwise);
	}

	/**
	 * Returns a human-readable string representation of the given Facing direction.
	 */
	public static function toString(Facing $facing) : string{
		return strtolower($facing->name);
	}
}
