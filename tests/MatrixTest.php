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

namespace pocketmine\math\tests;


use pocketmine\math\Matrix;
use PHPUnit\Framework\TestCase;

/**
 * Class for the Matrix class unit test
 */
class MatrixTest extends TestCase{

	public function testConstructor(){
		$matrix = new Matrix(1, 2);

		$this->assertSame(1, $matrix->getRows());
	}

	public function testOffsetExists(){
		$matrix = new Matrix(1, 2);

		$this->assertTrue($matrix->offsetExists(0));
		$this->assertFalse($matrix->offsetExists(1));
	}

	public function testOffsetGet(){
		$matrix = new Matrix(1, 2);

		$this->assertSame([0, 0],$matrix->offsetGet(0));
	}

	public function testOffsetSet(){
		$matrix = new Matrix(1, 2);
		$matrix->offsetSet(0, [1, 1]);

		$this->assertSame([1, 1], $matrix->offsetGet(0));
	}

	public function testOffsetUnset(){
		$matrix = new Matrix(1, 2);

		$this->assertNull($matrix->offsetUnset(0));
	}

	public function testSet(){
		$matrix = new Matrix(1, 2);
		$matrix->set([1, 1]);

		$this->assertSame([0, 0], $matrix->offsetGet(0));
	}

	public function testGetRows(){
		$matrix = new Matrix(1, 2);

		$this->assertSame(1, $matrix->getRows());
	}

	public function testGetColumns(){
		$matrix = new Matrix(1, 2);

		$this->assertSame(2, $matrix->getColumns());
	}

	public function testSetElement(){
		$matrix = new Matrix(1, 2);

		$this->assertTrue($matrix->setElement(0, 1, 3));
		$this->assertFalse($matrix->setElement(1, 3, 3));
	}

	public function testGetElement(){
		$matrix = new Matrix(1, 2);
		$matrix->setElement(0, 1, 3);

		$this->assertSame(3, $matrix->getElement(0, 1));
	}

	public function testGetElementOnInvalidRowColumn(){
		$matrix = new Matrix(1, 2);

		$this->assertFalse($matrix->getElement(-1, -1));
	}

	public function testIsSquare(){
		$matrix = new Matrix(2, 2);

		$this->assertTrue($matrix->isSquare());
	}

	public function testIsNotSquare(){
		$matrix = new Matrix(1, 2);

		$this->assertFalse($matrix->isSquare());
	}

	public function testAdd(){
		$matrix = new Matrix(1, 2);
		$matrix2 = new Matrix(1, 2);
		$matrix2->setElement(0, 1, 3);
		$result = $matrix->add($matrix2);

		$this->assertSame([0, 3], $result->offsetGet(0));
	}

	public function testAddOnRowColumnAreNotEqual(){
		$matrix = new Matrix(1, 2);
		$matrix2 = new Matrix(2, 1);

		$this->assertFalse($matrix->add($matrix2));
	}

	public function testSubtract(){
		$matrix = new Matrix(1, 2);
		$matrix2 = new Matrix(1, 2);
		$matrix2->setElement(0, 1, 3);
		$result = $matrix->subtract($matrix2);

		$this->assertSame([0, -3], $result->offsetGet(0));
	}

	public function testSubtractOnRowColumnAreNotEqual(){
		$matrix = new Matrix(1, 2);
		$matrix2 = new Matrix(2, 1);

		$this->assertFalse($matrix->subtract($matrix2));
	}

	public function testMultiplyScalar(){
		$matrix = new Matrix(1, 2);
		$matrix->setElement(0, 1, 3);
		$matrix->setElement(0, 0, 4);
		$result = $matrix->multiplyScalar(2);

		$this->assertSame([8, 6], $result->offsetGet(0));
	}

	public function testDivideScalar(){
		$matrix = new Matrix(1, 2);
		$matrix->setElement(0, 0, 8);
		$matrix->setElement(0, 1, 6);
		$result = $matrix->divideScalar(2);

		$this->assertSame([4, 3], $result->offsetGet(0));
	}

	public function testTranspose(){
		$matrix = new Matrix(2, 3);
		$result = $matrix->transpose();

		$this->assertSame([0, 0], $result->offsetGet(0));
	}

	public function testProductOnNonNaiveMatrix(){
		$matrix = new Matrix(2, 3);
		$matrix2 = new Matrix(2, 3);
		$matrix2->setElement(0, 0, 2);
		$matrix2->setElement(0, 1, 3);
		$result = $matrix->product($matrix2);

		$this->assertFalse($result);
	}

	public function testProduct(){
		$matrix = new Matrix(2, 2);
		$matrix->setElement(0, 0, 3);
		$matrix->setElement(0, 1, 4);
		$matrix2 = new Matrix(2, 2);
		$matrix2->setElement(0, 0, 2);
		$matrix2->setElement(0, 1, 3);
		$result = $matrix->product($matrix2);

		$this->assertSame([6, 9], $result->offsetGet(0));
		$this->assertSame([0, 0], $result->offsetGet(1));
	}

	public function determinantProvider(){
		return [
			[1, 1, 0],
		];
	}

	public function testDeterminantOnNonDeterminantMatrix(){
		$matrix = new Matrix(1, 2);
		$matrix2 = new Matrix(4, 4);

		$this->assertFalse($matrix->determinant());
		$this->assertFalse($matrix2->determinant());
	}

	public function testDeterminant(){
		$matrix = new Matrix(1, 1);
		$matrix2 = new Matrix(2, 2);
		$matrix2->setElement(0, 0, 1);
		$matrix2->setElement(0, 1, 2);
		$matrix2->setElement(1, 0, 3);
		$matrix2->setElement(1, 1, 4);
		$matrix3 = new Matrix(3, 3);
		$matrix3->setElement(0, 0, 1);
		$matrix3->setElement(0, 1, 2);
		$matrix3->setElement(0, 2, 3);
		$matrix3->setElement(1, 0, 4);
		$matrix3->setElement(1, 1, 6);
		$matrix3->setElement(1, 2, 6);
		$matrix3->setElement(2, 0, 7);
		$matrix3->setElement(2, 1, 8);
		$matrix3->setElement(2, 2, 9);

		$this->assertSame(0, $matrix->determinant());
		$this->assertSame(-2, $matrix2->determinant());
		$this->assertSame(-12, $matrix3->determinant());
	}

	public function testToString(){
		$matrix = new Matrix(1, 2);
		$matrix->setElement(0, 0, 2);

		$this->assertSame('Matrix(1x2;2,0)', (string) $matrix);
	}
}
