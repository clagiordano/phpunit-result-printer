<?php

namespace clagiordano\PhpunitResultPrinter\Tests;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

/**
 * Class ResultPrinterTest
 * @package clagiordano\PhpunitResultPrinter\Tests
 */
class ResultPrinterTest extends TestCase
{
    /**
     * @test
     */
    public function canHandleSuccessfulTest()
    {
        self::assertTrue(true);
    }

    /**
     * @test
     */
    public function canHandleFailedTest()
    {
        self::assertFalse(false, 'Sample failed test, not real fail');
    }

    #[Test] public function canHandleSkippedTest()
    {
        self::markTestSkipped('Sample skipped test');
    }

    #[Test] public function canHandleRiskyTest()
    {
        self::markTestIncomplete('This test is considered risky.');
    }

    #[Test] public function canHandleIncompleteTest()
    {
        self::markTestIncomplete('');
    }

    #[Test] public function canHandleErrorTest()
    {
        self::markTestIncomplete('');
    }
}
