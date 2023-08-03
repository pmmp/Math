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

final class Axis{
	private function __construct(){
		//NOOP
	}

	public const Y = 0;
	public const Z = 1;
	public const X = 2;

	/**
	 * Returns a human-readable string representation of the given axis.
	 */
	public static function toString(int $axis) : string{
		return match($axis){
			Axis::Y => "y",
			Axis::Z => "z",
			Axis::X => "x",
			default => throw new \InvalidArgumentException("Invalid axis $axis")
		};
	}
}
