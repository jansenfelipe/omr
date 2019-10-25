<?php

namespace JansenFelipe\OMR\Tests\Targets;

use PHPUnit\Framework\TestCase;

class TargetTest extends TestCase
{
    public function testTargetClassWillSetAndGet()
    {
        $target = new TargetHelperMock();

        $this->assertEquals(24, $target->getTolerance());
        $this->assertEquals(0, $target->getBlackPixelsPercent());
        $this->assertFalse($target->isMarked());


        $target->setTolerance(1337);
        $this->assertEquals(1337, $target->getTolerance());

        $target->setBlackPixelsPercent(1339);
        $this->assertEquals(1339, $target->getBlackPixelsPercent());

        $target->setMarked(true);
        $this->assertTrue($target->isMarked());
    }
}
