<?php

/*
 * This file is part of pmmp/Math.
 * Copyright (c) 2014-2024 PMMP Team <https://github.com/pmmp/Math>
 *
 * pmmp/Math is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

declare(strict_types=1);

namespace pocketmine\math;

use function abs;
use function iterator_to_array;
use function max;
use function min;
use function sqrt;

readonly class IntVector3{
	public function __construct(
		public int $x,
		public int $y,
		public int $z
	){}

	public static function zero() : IntVector3{
		//TODO: make this reuse a single object, once Vector3 becomes immutable
		return new self(0, 0, 0);
	}

	public function add(int $x, int $y, int $z) : IntVector3{
		return new IntVector3($this->x + $x, $this->y + $y, $this->z + $z);
	}

	public function addVector(IntVector3 $v) : IntVector3{
		return $this->add($v->x, $v->y, $v->z);
	}

	public function subtract(int $x, int $y, int $z) : IntVector3{
		return $this->add(-$x, -$y, -$z);
	}

	public function subtractVector(IntVector3 $v) : IntVector3{
		return $this->add(-$v->x, -$v->y, -$v->z);
	}

	public function multiply(int $number) : IntVector3{
		return new IntVector3($this->x * $number, $this->y * $number, $this->z * $number);
	}

	public function abs() : IntVector3{
		return new IntVector3(abs($this->x), abs($this->y), abs($this->z));
	}

	/**
	 * @return IntVector3
	 */
	public function getSide(Facing $side, int $step = 1){
		[$offsetX, $offsetY, $offsetZ] = $side->offset();

		return $this->add($offsetX * $step, $offsetY * $step, $offsetZ * $step);
	}

	/**
	 * @return IntVector3
	 */
	public function down(int $step = 1){
		return $this->getSide(Facing::DOWN, $step);
	}

	/**
	 * @return IntVector3
	 */
	public function up(int $step = 1){
		return $this->getSide(Facing::UP, $step);
	}

	/**
	 * @return IntVector3
	 */
	public function north(int $step = 1){
		return $this->getSide(Facing::NORTH, $step);
	}

	/**
	 * @return IntVector3
	 */
	public function south(int $step = 1){
		return $this->getSide(Facing::SOUTH, $step);
	}

	/**
	 * @return IntVector3
	 */
	public function west(int $step = 1){
		return $this->getSide(Facing::WEST, $step);
	}

	/**
	 * @return IntVector3
	 */
	public function east(int $step = 1){
		return $this->getSide(Facing::EAST, $step);
	}

	/**
	 * Yields vectors stepped out from this one in all directions.
	 *
	 * @param int $step Distance in each direction to shift the vector
	 *
	 * @return \Generator|IntVector3[]
	 * @phpstan-return \Generator<Facing, IntVector3, void, void>
	 */
	public function sides(int $step = 1) : \Generator{
		foreach(Facing::cases() as $facing){
			yield $facing => $this->getSide($facing, $step);
		}
	}

	/**
	 * Same as sides() but returns a pre-populated array instead of Generator.
	 *
	 * @return IntVector3[]
	 */
	public function sidesArray(bool $keys = false, int $step = 1) : array{
		return iterator_to_array($this->sides($step), $keys);
	}

	/**
	 * Yields vectors stepped out from this one in directions except those on the given axis.
	 *
	 * @param Axis $axis Facing directions on this axis will be excluded
	 *
	 * @return \Generator|IntVector3[]
	 * @phpstan-return \Generator<Facing, IntVector3, void, void>
	 */
	public function sidesAroundAxis(Axis $axis, int $step = 1) : \Generator{
		foreach(Facing::cases() as $facing){
			if($facing->axis() !== $axis){
				yield $facing => $this->getSide($facing, $step);
			}
		}
	}

	public function asIntVector3() : IntVector3{
		return new self($this->x, $this->y, $this->z);
	}

	public function distance(IntVector3 $pos) : float{
		return sqrt($this->distanceSquared($pos));
	}

	public function distanceSquared(IntVector3 $pos) : float{
		$dx = $this->x - $pos->x;
		$dy = $this->y - $pos->y;
		$dz = $this->z - $pos->z;
		return ($dx * $dx) + ($dy * $dy) + ($dz * $dz);
	}

	public function length() : float{
		return sqrt($this->lengthSquared());
	}

	public function lengthSquared() : float{
		return $this->x * $this->x + $this->y * $this->y + $this->z * $this->z;
	}

	public function dot(IntVector3 $v) : float{
		return $this->x * $v->x + $this->y * $v->y + $this->z * $v->z;
	}

	public function cross(IntVector3 $v) : IntVector3{
		return new IntVector3(
			$this->y * $v->z - $this->z * $v->y,
			$this->z * $v->x - $this->x * $v->z,
			$this->x * $v->y - $this->y * $v->x
		);
	}

	public function equals(IntVector3 $v) : bool{
		return $this->x === $v->x && $this->y === $v->y && $this->z === $v->z;
	}

	public function __toString(){
		return "IntVector3(x=" . $this->x . ",y=" . $this->y . ",z=" . $this->z . ")";
	}

	/**
	 * Returns a Vector3 with the provided components. If any of the components are null, the values from this
	 * Vector3 will be filled in instead.
	 * If no components are overridden (all components are null), the original vector will be returned unchanged.
	 */
	public function withComponents(?int $x, ?int $y, ?int $z) : IntVector3{
		if($x !== null || $y !== null || $z !== null){
			return new self($x ?? $this->x, $y ?? $this->y, $z ?? $this->z);
		}
		return $this;
	}

	/**
	 * Returns a new Vector3 taking the maximum of each component in the input vectors.
	 */
	public static function maxComponents(IntVector3 $vector, IntVector3 ...$vectors) : IntVector3{
		$x = $vector->x;
		$y = $vector->y;
		$z = $vector->z;
		foreach($vectors as $position){
			$x = max($x, $position->x);
			$y = max($y, $position->y);
			$z = max($z, $position->z);
		}
		return new IntVector3($x, $y, $z);
	}

	/**
	 * Returns a new Vector3 taking the minimum of each component in the input vectors.
	 */
	public static function minComponents(IntVector3 $vector, IntVector3 ...$vectors) : IntVector3{
		$x = $vector->x;
		$y = $vector->y;
		$z = $vector->z;
		foreach($vectors as $position){
			$x = min($x, $position->x);
			$y = min($y, $position->y);
			$z = min($z, $position->z);
		}
		return new IntVector3($x, $y, $z);
	}

	public static function sum(IntVector3 ...$vector3s) : IntVector3{
		$x = $y = $z = 0;
		foreach($vector3s as $vector3){
			$x += $vector3->x;
			$y += $vector3->y;
			$z += $vector3->z;
		}
		return new IntVector3($x, $y, $z);
	}
}
