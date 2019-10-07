<?php

namespace JansenFelipe\OMR\Tests;

use JansenFelipe\OMR\Point;
use PHPUnit\Framework\TestCase;

class PointTest extends TestCase
{
    /**
     * @dataProvider point
     */
    public function testPointShouldBeMovedCorrectlyInXAxis(Point $point)
    {
        $point->moveX(50);

        self::assertSame(100, $point->getX());
    }

    /**
     * @dataProvider point
     */
    public function testPointShouldBeMovedCorrectlyInYAxis(Point $point)
    {
        $point->moveY(50);

        self::assertSame(100, $point->getY());
    }

    public function point()
    {
        return [
            'Point int (50, 50)' => [new Point(50, 50)]
        ];
    }
}
