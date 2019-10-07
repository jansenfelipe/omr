<?php

namespace JansenFelipe\OMR\Tests;

use JansenFelipe\OMR\Contracts\Target;
use JansenFelipe\OMR\Result;
use PHPUnit\Framework\TestCase;

class ResultTest extends TestCase
{
    public function testEmptyResultShouldBeCorrectlyConvertedToArray()
    {
        $result = new Result();
        $resultToArray = $result->toArray();

        self::assertIsArray($resultToArray);
        self::assertArrayHasKey('targets', $resultToArray);
        self::assertEmpty($resultToArray['targets']);
    }

    public function testResultWithTargetsShouldBeCorrectlyConvertedToArray()
    {
        $result = new Result();
        $result->addTarget(new class extends Target {});
        $result->addTarget(new class extends Target {
            public function __construct()
            {
                $this->marked = true;
            }
        });
        $resultToArray = $result->toArray();

        self::assertIsArray($resultToArray);
        self::assertArrayHasKey('targets', $resultToArray);
        self::assertCount(2, $resultToArray['targets']);
        self::assertSame('no', $resultToArray['targets'][0]['marked']);
        self::assertSame('yes', $resultToArray['targets'][1]['marked']);
    }
}
