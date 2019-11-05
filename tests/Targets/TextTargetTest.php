<?php

namespace JansenFelipe\OMR\Tests;

use JansenFelipe\OMR\Point;
use JansenFelipe\OMR\Targets\TextTarget;
use PHPUnit\Framework\TestCase;

class TextTargetTest extends TestCase
{
    public function testCircleClassWillServeDefaultAttributes()
    {
        $pointA = new Point(1337, 1338);
        $pointB = new Point(1335, 1336);
        $text = new TextTarget('foo', $pointA, $pointB);

        $this->assertEquals('foo', $text->getId());
        $this->assertEquals($pointA, $text->getA());
        $this->assertEquals($pointB, $text->getB());

        $text->setImageBlob('bar');
        $this->assertEquals('bar', $text->getImageBlob());
    }
}
