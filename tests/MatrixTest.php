<?php

namespace Tests;

use Runey\Run\Model\Run;
use Runey\User\Handler\UpdateKmHandler;
use Runey\User\Helper\UserLevelHelper;
use Runey\User\Model\User;

class MatrixTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerMapSub
     */
    public function testMapSub($config, $result)
    {
        $m = new \Matrix(
            [
                [11, 12, 13, 14],
                [15, 16, 17, 18],
                [19, 20, 21, 22],
            ]
        );

        list($x, $y, $h, $w) = $config;
        $s = $m->mapSub($x, $y, $h, $w);

        self::assertEquals($result, $s->elements);
    }

    public function providerMapSub()
    {
        return array(
            array([1, 0, 2, 2], [[12, 13], [16, 17]]),
            array([0, 0, 1, 1], [[11]]),
            array([2, 0, 1, 3], [[13], [17], [21]]),
        );
    }
}