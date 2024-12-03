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

enum Facing{
	case DOWN;
	case UP;
	case NORTH;
	case SOUTH;
	case WEST;
	case EAST;

	public const HORIZONTAL = [
		self::NORTH,
		self::SOUTH,
		self::WEST,
		self::EAST
	];

	/**
	 * Returns the axis of the given direction.
	 */
	public function axis() : Axis{
		return match($this){
			self::DOWN, self::UP => Axis::Y,
			self::NORTH, self::SOUTH => Axis::Z,
			self::WEST, self::EAST => Axis::X,
		};
	}

	/**
	 * @phpstan-return array{-1|0|1, -1|0|1, -1|0|1}
	 */
	public function offset() : array{
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
	 * Returns whether the direction is facing the positive of its axis.
	 */
	public function isPositive() : bool{
		return match($this){
			self::UP, self::SOUTH, self::EAST => true,
			self::DOWN, self::NORTH, self::WEST => false,
		};
	}

	/**
	 * Returns the opposite Facing of the specified one.
	 */
	public function opposite() : Facing{
		return match($this){
			self::DOWN => self::UP,
			self::UP => self::DOWN,
			self::NORTH => self::SOUTH,
			self::SOUTH => self::NORTH,
			self::WEST => self::EAST,
			self::EAST => self::WEST,
		};
	}

	/**
	 * Rotates the given direction around the axis.
	 *
	 * @throws \InvalidArgumentException if not possible to rotate this direction around $axis
	 */
	public function rotate(Axis $axis, bool $clockwise) : Facing{
		$rotated = match($axis){
			Axis::Y => match($this){
				self::NORTH => self::EAST,
				self::EAST => self::SOUTH,
				self::SOUTH => self::WEST,
				self::WEST => self::NORTH,
				default => null
			},
			Axis::Z => match($this){
				self::UP => self::EAST,
				self::EAST => self::DOWN,
				self::DOWN => self::WEST,
				self::WEST => self::UP,
				default => null
			},
			Axis::X => match($this){
				self::UP => self::NORTH,
				self::NORTH => self::DOWN,
				self::DOWN => self::SOUTH,
				self::SOUTH => self::UP,
				default => null
			}
		};

		if($rotated === null) {
			throw new \InvalidArgumentException("Cannot rotate facing \"" . strtolower($this->name) . "\" around axis \"" . strtolower($axis->name) . "\"");
		}

		return $clockwise ? $rotated : $rotated->opposite();
	}

	public function rotateY(bool $clockwise) : Facing{
		return $this->rotate(Axis::Y, $clockwise);
	}

	public function rotateZ(bool $clockwise) : Facing{
		return $this->rotate(Axis::Z, $clockwise);
	}

	public function rotateX(bool $clockwise) : Facing{
		return $this->rotate(Axis::X, $clockwise);
	}
}
