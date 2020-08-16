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

use function abs;
use function ceil;
use function floor;
use function iterator_to_array;
use function max;
use function min;
use function round;
use function sqrt;
use const PHP_ROUND_HALF_UP;

class Vector3{
	/** @var float|int */
	public $x;
	/** @var float|int */
	public $y;
	/** @var float|int */
	public $z;

	/**
	 * WARNING: THIS IS NOT TYPE SAFE!
	 * This is intentionally not typehinted because things using this as an int-vector will crash and burn if everything
	 * gets converted to floating-point numbers.
	 *
	 * TODO: typehint this once int-vectors and float-vectors are separated
	 *
	 * @param float|int $x
	 * @param float|int $y
	 * @param float|int $z
	 */
	public function __construct($x, $y, $z){
		$this->x = $x;
		$this->y = $y;
		$this->z = $z;
	}

	/**
	 * @return float|int
	 */
	public function getX(){
		return $this->x;
	}

	/**
	 * @return float|int
	 */
	public function getY(){
		return $this->y;
	}

	/**
	 * @return float|int
	 */
	public function getZ(){
		return $this->z;
	}

	public function getFloorX() : int{
		return (int) floor($this->x);
	}

	public function getFloorY() : int{
		return (int) floor($this->y);
	}

	public function getFloorZ() : int{
		return (int) floor($this->z);
	}

	/**
	 * WARNING: THIS IS NOT TYPE SAFE!
	 * This is intentionally not typehinted because things using this as an int-vector will crash and burn if everything
	 * gets converted to floating-point numbers.
	 *
	 * TODO: typehint this once int-vectors and float-vectors are separated
	 *
	 * @param int|float $x
	 * @param int|float $y
	 * @param int|float $z
	 */
	public function add($x, $y, $z) : Vector3{
		$uniq = thisrc() === 1 ? $this : clone $this;
		$uniq->x += $x;
		$uniq->y += $y;
		$uniq->z += $z;
		return $uniq;
	}

	public function addVector(Vector3 $v) : Vector3{
		$uniq = thisrc() === 1 ? $this : clone $this;
		$uniq->x += $v->x;
		$uniq->y += $v->y;
		$uniq->z += $v->z;
		return $uniq;
	}

	/**
	 * WARNING: THIS IS NOT TYPE SAFE!
	 * This is intentionally not typehinted because things using this as an int-vector will crash and burn if everything
	 * gets converted to floating-point numbers.
	 *
	 * TODO: typehint this once int-vectors and float-vectors are separated
	 *
	 * @param int|float $x
	 * @param int|float $y
	 * @param int|float $z
	 */
	public function subtract($x, $y, $z) : Vector3{
		$uniq = thisrc() === 1 ? $this : clone $this;
		$uniq->x -= $x;
		$uniq->y -= $y;
		$uniq->z -= $z;
		return $uniq;
	}

	public function subtractVector(Vector3 $v) : Vector3{
		$uniq = thisrc() === 1 ? $this : clone $this;
		$uniq->x -= $v->x;
		$uniq->y -= $v->y;
		$uniq->z -= $v->z;
		return $uniq;
	}

	public function multiply(float $number) : Vector3{
		$uniq = thisrc() === 1 ? $this : clone $this;
		$uniq->x *= $x;
		$uniq->y *= $y;
		$uniq->z *= $z;
		return $uniq;
	}

	public function divide(float $number) : Vector3{
		$uniq = thisrc() === 1 ? $this : clone $this;
		$uniq->x /= $x;
		$uniq->y /= $y;
		$uniq->z /= $z;
		return $uniq;
	}

	public function ceil() : Vector3{
		$uniq = thisrc() === 1 ? $this : clone $this;
		$uniq->x = (int) ceil($uniq->x);
		$uniq->y = (int) ceil($uniq->y);
		$uniq->z = (int) ceil($uniq->z);
		return $uniq;
	}

	public function floor() : Vector3{
		$uniq = thisrc() === 1 ? $this : clone $this;
		$uniq->x = (int) floor($uniq->x);
		$uniq->y = (int) floor($uniq->y);
		$uniq->z = (int) floor($uniq->z);
		return $uniq;
	}

	public function round(int $precision = 0, int $mode = PHP_ROUND_HALF_UP) : Vector3{
		$uniq = thisrc() === 1 ? $this : clone $this;
		$uniq->x = round($uniq->x, $precision, $mode);
		$uniq->y = round($uniq->y, $precision, $mode);
		$uniq->z = round($uniq->z, $precision, $mode);
		if($precision <= 0) {
			$uniq->x = (int) $uniq->x;
			$uniq->y = (int) $uniq->y;
			$uniq->z = (int) $uniq->z;
		}
		return $uniq;
	}

	public function abs() : Vector3{
		$uniq = thisrc() === 1 ? $this : clone $this;
		$uniq->x = abs($uniq->x);
		$uniq->y = abs($uniq->y);
		$uniq->z = abs($uniq->z);
		return $uniq;
	}

	/**
	 * @return Vector3
	 */
	public function getSide(int $side, int $step = 1){
		$uniq = thisrc() === 1 ? $this : clone $this;
		switch($side){
			case Facing::DOWN:
				$uniq->y -= $step;
				break;
			case Facing::UP:
				$uniq->y += $step;
				break;
			case Facing::NORTH:
				$uniq->z -= $step;
				break;
			case Facing::SOUTH:
				$uniq->z += $step;
				break;
			case Facing::WEST:
				$uniq->x -= $step;
				break;
			case Facing::EAST:
				$uniq->x += $step;
				break;
		}
		return $uniq;
	}

	/**
	 * @return Vector3
	 */
	public function down(int $step = 1){
		$uniq = thisrc() === 1 ? $this : clone $this;
		$uniq->y -= $step;
		return $uniq;
	}

	/**
	 * @return Vector3
	 */
	public function up(int $step = 1){
		$uniq = thisrc() === 1 ? $this : clone $this;
		$uniq->y += $step;
		return $uniq;
	}

	/**
	 * @return Vector3
	 */
	public function north(int $step = 1){
		$uniq = thisrc() === 1 ? $this : clone $this;
		$uniq->z -= $step;
		return $uniq;
	}

	/**
	 * @return Vector3
	 */
	public function south(int $step = 1){
		$uniq = thisrc() === 1 ? $this : clone $this;
		$uniq->z += $step;
		return $uniq;
	}

	/**
	 * @return Vector3
	 */
	public function west(int $step = 1){
		$uniq = thisrc() === 1 ? $this : clone $this;
		$uniq->x -= $step;
		return $uniq;
	}

	/**
	 * @return Vector3
	 */
	public function east(int $step = 1){
		$uniq = thisrc() === 1 ? $this : clone $this;
		$uniq->x += $step;
		return $uniq;
	}

	/**
	 * Yields vectors stepped out from this one in all directions.
	 *
	 * @param int $step Distance in each direction to shift the vector
	 *
	 * @return \Generator|Vector3[]
	 * @phpstan-return \Generator<int, Vector3, void, void>
	 */
	public function sides(int $step = 1) : \Generator{
		foreach(Facing::ALL as $facing){
			yield $facing => $this->getSide($facing, $step);
		}
	}

	/**
	 * Same as sides() but returns a pre-populated array instead of Generator.
	 *
	 * @return Vector3[]
	 */
	public function sidesArray(bool $keys = false, int $step = 1) : array{
		return iterator_to_array($this->sides($step), $keys);
	}

	/**
	 * Yields vectors stepped out from this one in directions except those on the given axis.
	 *
	 * @param int $axis Facing directions on this axis will be excluded
	 *
	 * @return \Generator|Vector3[]
	 * @phpstan-return \Generator<int, Vector3, void, void>
	 */
	public function sidesAroundAxis(int $axis, int $step = 1) : \Generator{
		foreach(Facing::ALL as $facing){
			if(Facing::axis($facing) !== $axis){
				yield $facing => $this->getSide($facing, $step);
			}
		}
	}

	/**
	 * Return a Vector3 instance
	 */
	public function asVector3() : Vector3{
		return new Vector3($this->x, $this->y, $this->z);
	}

	public function distance(Vector3 $pos) : float{
		return sqrt($this->distanceSquared($pos));
	}

	public function distanceSquared(Vector3 $pos) : float{
		return (($this->x - $pos->x) ** 2) + (($this->y - $pos->y) ** 2) + (($this->z - $pos->z) ** 2);
	}

	/**
	 * @param Vector3|Vector2|float $x
	 * @param float                 $z
	 */
	public function maxPlainDistance($x, $z = 0) : float{
		if($x instanceof Vector3){
			return $this->maxPlainDistance($x->x, $x->z);
		}elseif($x instanceof Vector2){
			return $this->maxPlainDistance($x->x, $x->y);
		}else{
			return max(abs($this->x - $x), abs($this->z - $z));
		}
	}

	public function length() : float{
		return sqrt($this->lengthSquared());
	}

	public function lengthSquared() : float{
		return $this->x * $this->x + $this->y * $this->y + $this->z * $this->z;
	}

	public function normalize() : Vector3{
		$uniq = thisrc() === 1 ? $this : clone $this;
		$len2 = $uniq->lengthSquared();
		if($len2 === 0.0) { // return type hint of `lengthSquared` guarantees $len2 is float
			$uniq->x = 0;
			$uniq->y = 0;
			$uniq->z = 0;
		} else {
			$len = sqrt($len2);
			$uniq->x /= $len;
			$uniq->y /= $len;
			$uniq->z /= $len;
		}
		return $uniq;
	}

	public function dot(Vector3 $v) : float{
		return $this->x * $v->x + $this->y * $v->y + $this->z * $v->z;
	}

	public function cross(Vector3 $v) : Vector3{
		$uniq = thisrc() === 1 ? $this : clone $this;

		// clone properties first, may be overwritten
		$x = $uniq->x;
		$y = $uniq->y;
		$z = $uniq->z;

		$uniq->x = $y * $v->z - $z * $v->y;
		$uniq->y = $z * $v->x - $x * $v->z;
		$uniq->z = $x * $v->y - $y * $v->x;
		return $uniq;
	}

	public function equals(Vector3 $v) : bool{
		return $this->x == $v->x and $this->y == $v->y and $this->z == $v->z;
	}

	/**
	 * Returns a new vector with x value equal to the second parameter, along the line between this vector and the
	 * passed in vector, or null if not possible.
	 */
	public function getIntermediateWithXValue(Vector3 $v, float $x) : ?Vector3{
		$xDiff = $v->x - $this->x;
		if(($xDiff * $xDiff) < 0.0000001){
			return null;
		}

		$f = ($x - $this->x) / $xDiff;

		if($f < 0 or $f > 1){
			return null;
		}else{
			$uniq = thisrc() === 1 ? $this : clone $this;
			$uniq->x = $x;
			$uniq->y += ($v->y - $uniq->y) * $f;
			$uniq->z += ($v->z - $uniq->z) * $f;
			return $uniq;
		}
	}

	/**
	 * Returns a new vector with y value equal to the second parameter, along the line between this vector and the
	 * passed in vector, or null if not possible.
	 */
	public function getIntermediateWithYValue(Vector3 $v, float $y) : ?Vector3{
		$yDiff = $v->y - $this->y;
		if(($yDiff * $yDiff) < 0.0000001){
			return null;
		}

		$f = ($y - $this->y) / $yDiff;

		if($f < 0 or $f > 1){
			return null;
		}else{
			$uniq = thisrc() === 1 ? $this : clone $this;
			$uniq->x += ($v->x - $uniq->x) * $f;
			$uniq->y = $y;
			$uniq->z += ($v->z - $uniq->z) * $f;
			return $uniq;
		}
	}

	/**
	 * Returns a new vector with z value equal to the second parameter, along the line between this vector and the
	 * passed in vector, or null if not possible.
	 */
	public function getIntermediateWithZValue(Vector3 $v, float $z) : ?Vector3{
		$zDiff = $v->z - $this->z;
		if(($zDiff * $zDiff) < 0.0000001){
			return null;
		}

		$f = ($z - $this->z) / $zDiff;

		if($f < 0 or $f > 1){
			return null;
		}else{
			$uniq = thisrc() === 1 ? $this : clone $this;
			$uniq->x += ($v->x - $uniq->x) * $f;
			$uniq->y += ($v->y - $uniq->y) * $f;
			$uniq->z = $z;
			return $uniq;
		}
	}

	public function __toString(){
		return "Vector3(x=" . $this->x . ",y=" . $this->y . ",z=" . $this->z . ")";
	}

	/**
	 * Returns a new Vector3 taking the maximum of each component in the input vectors.
	 *
	 * @param Vector3 ...$positions
	 */
	public static function maxComponents(Vector3 ...$positions) : Vector3{
		$xList = $yList = $zList = [];
		foreach($positions as $position){
			$xList[] = $position->x;
			$yList[] = $position->y;
			$zList[] = $position->z;
		}
		return new Vector3(max($xList), max($yList), max($zList));
	}

	/**
	 * Returns a new Vector3 taking the minimum of each component in the input vectors.
	 *
	 * @param Vector3 ...$positions
	 */
	public static function minComponents(Vector3 ...$positions) : Vector3{
		$xList = $yList = $zList = [];
		foreach($positions as $position){
			$xList[] = $position->x;
			$yList[] = $position->y;
			$zList[] = $position->z;
		}
		return new Vector3(min($xList), min($yList), min($zList));
	}

	public static function sum(Vector3 ...$vector3s) : Vector3{
		$x = $y = $z = 0;
		foreach($vector3s as $vector3){
			$x += $vector3->x;
			$y += $vector3->y;
			$z += $vector3->z;
		}
		return new Vector3($x, $y, $z);
	}
}
