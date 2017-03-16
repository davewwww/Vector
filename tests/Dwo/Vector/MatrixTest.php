<?php

namespace Tests\Dwo\Vector;

use Dwo\Vector\Matrix;
use Dwo\Vector\Position;

class MatrixTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Matrix
     */
    private $matrix;
    /**
     * @var Matrix
     */
    private $matrixVector;

    public function setUp()
    {
        $this->matrix = new Matrix(
            [
                [11, 12, 13, 14],
                [15, 16, 17, 18],
                [19, 20, 21, 22],
            ]
        );

        $this->matrixVector = new Matrix(
            [
                [11, 11, 73, 73],
                [11, 11, 73, 88],
                [11, 20, 20, 88],
                [33, 20, 20, 88],
            ]
        );
    }

    public function testGet()
    {
        self::assertEquals(11, $this->matrix->get(0, 0));
        self::assertEquals(null, $this->matrix->get(5, 5));
    }

    public function testHasRight()
    {
        self::assertTrue($this->matrix->hasRight(0));
        self::assertTrue($this->matrix->hasRight(2));
        self::assertFalse($this->matrix->hasRight(3));
    }

    /**
     * @dataProvider providerMapSub
     */
    public function testMapSub($config, $result)
    {
        list($x, $y, $h, $w) = $config;
        $s = $this->matrix->mapSub(new Position($x, $y), $h, $w);

        self::assertEquals($result, $s->elements);
    }

    public function providerMapSub()
    {
        return array(
            array([1, 0, 2, 2], [[12, 13], [16, 17]]),
            array([0, 0, 1, 1], [[11]]),
            array([2, 0, 1, 3], [[13], [17], [21]]),
            array([3, 2, 2, 2], [[22]]),
        );
    }
}