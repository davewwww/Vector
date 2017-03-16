<?php

namespace Tests\Dwo\Vector\Finder;

use Dwo\Vector\Finder\VectorFinderV2;
use Dwo\Vector\Matrix;
use Dwo\Vector\Restrictor\DefaultVectorRestrictor;

class VectorFinderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DefaultVectorRestrictor
     */
    private $restrictor;
    /**
     * @var Matrix
     */
    private $matrix;
    /**
     * @var Matrix
     */
    private $matrix2;
    /**
     * @var Matrix
     */
    private $matrix3;

    public function setUp()
    {
        $this->restrictor = new DefaultVectorRestrictor('1x1 1x2 1x3 1x4 1x6 2x2 2x3 2x4');

        $this->matrix = new Matrix(
            [
                [11, 11, 73, 73],
                [11, 11, 73, 88],
                [11, 20, 20, 88],
                [33, 20, 20, 88],
            ]
        );

        $this->matrix2 = new Matrix(
            [
                [11, 11, 68, 68],
                [11, 68, 68, 68],
                [11, 11, 68, 68],
                [11, 11, 11, 68],
                [11, 11, 11, 68],
                [11, 11, 68, 68],
                [11, 68, 68, 68],
                [68, 68, 68, 68],
            ]
        );

        $this->matrix3 = new Matrix(
            [
                [11, 11, 68, 68],
                [11, 11, 68, 68],
                [11, 11, 11, 11],
                [11, 11, 11, 11],
            ]
        );
    }

    public function testCreateVectorsWithSameValue()
    {
        $possibleVectors = (new VectorFinderV2()) -> findPossibleVectors($this->matrix3, $this->restrictor);

        $grouped = [];
        foreach($possibleVectors as $vector) {

            $key = implode('x',$vector->position->get()) .' '. $vector->getValue();
            if(!isset($grouped[$key])) {
                $grouped[$key] = [];
            }

            if ($vector->height > 1 || $vector->width > 1) {
                $grouped[$key][] = implode('x',$vector->getWidthAndHeight());
            }
        }

        td($grouped);
    }
}