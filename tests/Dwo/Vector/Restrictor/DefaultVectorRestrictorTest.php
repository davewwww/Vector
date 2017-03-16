<?php

namespace Tests\Dwo\Vector\Restrictor;

use Dwo\Vector\Restrictor\DefaultVectorRestrictor;

class DefaultVectorRestrictorTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateFromString()
    {
        $a = new DefaultVectorRestrictor('1x1');
        self::assertEquals([[1, 1]], $a->sizes);

        $a = new DefaultVectorRestrictor('1x1, 1x2 2x2   2x3');
        self::assertEquals([[1, 1], [1, 2], [2, 2], [2, 3]], $a->sizes);
    }

    public function testGetOpposite()
    {
        $vr = new DefaultVectorRestrictor('1x1, 1x2 2x2   2x3');

        self::assertEquals([1, 2], $vr->getOpposites(1));
        self::assertEquals([1, 2, 3], $vr->getOpposites(2));
        self::assertEquals([2], $vr->getOpposites(3));
    }
}