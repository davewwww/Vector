<?php

namespace Tests\Dwo\Vector;

use Dwo\Vector\Position;
use Dwo\Vector\Value;
use Dwo\Vector\Vector;
use Dwo\Vector\VectorReference;

class ValueTest extends \PHPUnit_Framework_TestCase
{
    public function testIsValue()
    {
        self::assertTrue(Value::isValue(123));
        self::assertTrue(Value::isValue('foo'));

        self::assertFalse(Value::isValue(null));
        self::assertFalse(Value::isValue($v = new Vector(new Position(0,0), 0, 0, 0)));
        self::assertFalse(Value::isValue(new VectorReference($v)));
    }
}