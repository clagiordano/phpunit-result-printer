<?php

namespace clagiordano\PhpunitResultPrinter\Tests;

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
        self::assertTrue(false, 'Sample failed test, not real fail');
    }

    /**
     * @test
     */
    public function canHandleSkippedTest()
    {
        self::markTestSkipped('Sample skipped test');
    }

    /**
     * @test
     */
    public function canHandleRiskyTest()
    {
        self::markAsRisky();
    }

    /**
     * @test
     */
    public function canHandleIncompleteTest()
    {
        self::markTestIncomplete();
    }

    /**
     * @test
     */
    public function canHandleErrorTest()
    {
        void();
    }
}
