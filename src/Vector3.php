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
	public function __construct($x = 0, $y = 0, $z = 0){
		$this->x = $x;
		$this->y = $y;
		$this->z = $z;
	}

	public function getX(){
		return $this->x;
	}

	public function getY(){
		return $this->y;
	}

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
	 * @param Vector3|int $x
	 * @param int         $y
	 * @param int         $z
	 *
	 * @return Vector3
	 */
	public function add($x, $y = 0, $z = 0) : Vector3{
		if($x instanceof Vector3){
			return new Vector3($this->x + $x->x, $this->y + $x->y, $this->z + $x->z);
		}else{
			return new Vector3($this->x + $x, $this->y + $y, $this->z + $z);
		}
	}

	/**
	 * @param Vector3|int $x
	 * @param int         $y
	 * @param int         $z
	 *
	 * @return Vector3
	 */
	public function subtract($x = 0, $y = 0, $z = 0) : Vector3{
		if($x instanceof Vector3){
			return $this->add(-$x->x, -$x->y, -$x->z);
		}else{
			return $this->add(-$x, -$y, -$z);
		}
	}

	public function multiply(float $number) : Vector3{
		return new Vector3($this->x * $number, $this->y * $number, $this->z * $number);
	}

	public function divide(float $number) : Vector3{
		return new Vector3($this->x / $number, $this->y / $number, $this->z / $number);
	}

	public function ceil() : Vector3{
		return new Vector3((int) ceil($this->x), (int) ceil($this->y), (int) ceil($this->z));
	}

	public function floor() : Vector3{
		return new Vector3((int) floor($this->x), (int) floor($this->y), (int) floor($this->z));
	}

	public function round(int $precision = 0, int $mode = PHP_ROUND_HALF_UP) : Vector3{
		return $precision > 0 ?
			new Vector3(round($this->x, $precision, $mode), round($this->y, $precision, $mode), round($this->z, $precision, $mode)) :
			new Vector3((int) round($this->x, $precision, $mode), (int) round($this->y, $precision, $mode), (int) round($this->z, $precision, $mode));
	}

	public function abs() : Vector3{
		return new Vector3(abs($this->x), abs($this->y), abs($this->z));
	}

	/**
	 * @param int $side
	 * @param int $step
	 *
	 * @return Vector3
	 */
	public function getSide(int $side, int $step = 1){
		switch($side){
			case Facing::DOWN:
				return new Vector3($this->x, $this->y - $step, $this->z);
			case Facing::UP:
				return new Vector3($this->x, $this->y + $step, $this->z);
			case Facing::NORTH:
				return new Vector3($this->x, $this->y, $this->z - $step);
			case Facing::SOUTH:
				return new Vector3($this->x, $this->y, $this->z + $step);
			case Facing::WEST:
				return new Vector3($this->x - $step, $this->y, $this->z);
			case Facing::EAST:
				return new Vector3($this->x + $step, $this->y, $this->z);
			default:
				return $this;
		}
	}

	/**
	 * @param int $step
	 *
	 * @return Vector3
	 */
	public function down(int $step = 1){
		return $this->getSide(Facing::DOWN, $step);
	}

	/**
	 * @param int $step
	 *
	 * @return Vector3
	 */
	public function up(int $step = 1){
		return $this->getSide(Facing::UP, $step);
	}

	/**
	 * @param int $step
	 *
	 * @return Vector3
	 */
	public function north(int $step = 1){
		return $this->getSide(Facing::NORTH, $step);
	}

	/**
	 * @param int $step
	 *
	 * @return Vector3
	 */
	public function south(int $step = 1){
		return $this->getSide(Facing::SOUTH, $step);
	}

	/**
	 * @param int $step
	 *
	 * @return Vector3
	 */
	public function west(int $step = 1){
		return $this->getSide(Facing::WEST, $step);
	}

	/**
	 * @param int $step
	 *
	 * @return Vector3
	 */
	public function east(int $step = 1){
		return $this->getSide(Facing::EAST, $step);
	}

	/**
	 * Yields vectors stepped out from this one in all directions.
	 *
	 * @param int $step Distance in each direction to shift the vector
	 *
	 * @return \Generator|Vector3[]
	 */
	public function sides(int $step = 1) : \Generator{
		foreach(Facing::ALL as $facing){
			yield $facing => $this->getSide($facing, $step);
		}
	}

	/**
	 * Same as sides() but returns a pre-populated array instead of Generator.
	 *
	 * @param bool $keys
	 * @param int  $step
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
	 * @param int $step
	 *
	 * @return \Generator|Vector3[]
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
	 *
	 * @return Vector3
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

	public function maxPlainDistance($x = 0, $z = 0) : float{
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

	/**
	 * @return Vector3
	 */
	public function normalize() : Vector3{
		$len = $this->lengthSquared();
		if($len > 0){
			return $this->divide(sqrt($len));
		}

		return new Vector3(0, 0, 0);
	}

	public function dot(Vector3 $v) : float{
		return $this->x * $v->x + $this->y * $v->y + $this->z * $v->z;
	}

	public function cross(Vector3 $v) : Vector3{
		return new Vector3(
			$this->y * $v->z - $this->z * $v->y,
			$this->z * $v->x - $this->x * $v->z,
			$this->x * $v->y - $this->y * $v->x
		);
	}

	public function equals(Vector3 $v) : bool{
		return $this->x == $v->x and $this->y == $v->y and $this->z == $v->z;
	}

	/**
	 * Returns a new vector with x value equal to the second parameter, along the line between this vector and the
	 * passed in vector, or null if not possible.
	 *
	 * @param Vector3 $v
	 * @param float   $x
	 *
	 * @return Vector3|null
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
			return new Vector3($x, $this->y + ($v->y - $this->y) * $f, $this->z + ($v->z - $this->z) * $f);
		}
	}

	/**
	 * Returns a new vector with y value equal to the second parameter, along the line between this vector and the
	 * passed in vector, or null if not possible.
	 *
	 * @param Vector3 $v
	 * @param float   $y
	 *
	 * @return Vector3|null
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
			return new Vector3($this->x + ($v->x - $this->x) * $f, $y, $this->z + ($v->z - $this->z) * $f);
		}
	}

	/**
	 * Returns a new vector with z value equal to the second parameter, along the line between this vector and the
	 * passed in vector, or null if not possible.
	 *
	 * @param Vector3 $v
	 * @param float   $z
	 *
	 * @return Vector3|null
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
			return new Vector3($this->x + ($v->x - $this->x) * $f, $this->y + ($v->y - $this->y) * $f, $z);
		}
	}

	/**
	 * @param $x
	 * @param $y
	 * @param $z
	 *
	 * @return $this
	 */
	public function setComponents($x, $y, $z){
		$this->x = $x;
		$this->y = $y;
		$this->z = $z;
		return $this;
	}

	public function __toString(){
		return "Vector3(x=" . $this->x . ",y=" . $this->y . ",z=" . $this->z . ")";
	}

}
