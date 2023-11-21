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

enum Facing{
	case DOWN;
	case UP;
	case NORTH;
	case SOUTH;
	case WEST;
	case EAST;

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
		return match ($direction) {
			self::DOWN, self::UP => Axis::Y,
			self::NORTH, self::SOUTH => Axis::Z,
			self::WEST, self::EAST => Axis::X,
		};
	}

	/**
	 * Returns whether the direction is facing the positive of its axis.
	 */
	public static function isPositive(Facing $direction) : bool{
		return in_array($direction, [self::UP, self::SOUTH, self::EAST]);
	}

	/**
	 * Returns the opposite Facing of the specified one.
	 */
	public static function opposite(Facing $direction) : Facing{
		return match ($direction) {
			self::DOWN => self::UP,
			self::NORTH => self::SOUTH,
			self::WEST => self::EAST,
			self::UP => self::DOWN,
			self::SOUTH => self::NORTH,
			self::EAST => self::WEST,
		};
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