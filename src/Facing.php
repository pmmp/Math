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
	 * @phpstan-return non-empty-array<int>
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
		return $this === self::UP || $this === self::SOUTH || $this === self::EAST;
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
	 * @throws \InvalidArgumentException
	 */
	public function rotate(Axis $axis, bool $clockwise) : Facing{
		$rotated = match($axis){
			Axis::Y => match($this){
				self::NORTH => self::EAST,
				self::EAST => self::SOUTH,
				self::SOUTH => self::WEST,
				self::WEST => self::NORTH,
				default => throw new \InvalidArgumentException("Face " . strtolower($this->name) . " not match with Axis " . strtolower($axis->name))
			},
			Axis::Z => match($this){
				self::UP => self::EAST,
				self::EAST => self::DOWN,
				self::DOWN => self::WEST,
				self::WEST => self::UP,
				default => throw new \InvalidArgumentException("Face " . strtolower($this->name) . " not match with Axis " . strtolower($axis->name))
			},
			Axis::X => match($this){
				self::UP => self::NORTH,
				self::NORTH => self::DOWN,
				self::DOWN => self::SOUTH,
				self::SOUTH => self::UP,
				default => throw new \InvalidArgumentException("Face " . strtolower($this->name) . " not match with Axis " . strtolower($axis->name))
			}
		};

		return $clockwise ? $rotated : $rotated->opposite();
	}

	/**
	 * Rotates the given direction around the Y axis.
	 * 
	 * @see Facing::rotate()
	 * @throws \InvalidArgumentException
	 */
	public function rotateY(bool $clockwise) : Facing{
		return $this->rotate(Axis::Y, $clockwise);
	}

	/**
	 * Rotates the given direction around the Z axis.
	 * 
	 * @see Facing::rotate()
	 * @throws \InvalidArgumentException
	 */
	public function rotateZ(bool $clockwise) : Facing{
		return $this->rotate(Axis::Z, $clockwise);
	}

	/**
	 * Rotates the given direction around the X axis.
	 * 
	 * @see Facing::rotate()
	 * @throws \InvalidArgumentException
	 */
	public function rotateX(bool $clockwise) : Facing{
		return $this->rotate(Axis::X, $clockwise);
	}
}
