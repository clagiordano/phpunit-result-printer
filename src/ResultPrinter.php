<?php

namespace clagiordano\PhpunitResultPrinter;

use PHPUnit_Framework_Test;
use PHPUnit_Framework_TestSuite;

/**
 * Class ResultPrinter
 * @package clagiordano\MarketplacesDataExport
 */
class ResultPrinter extends \PHPUnit_TextUI_ResultPrinter
{
    /** @var double $executionTime */
    protected $executionTime = 0.00;
    /** @var string $testStatus */
    protected $testStatus = null;
    /** @var string $testName */
    protected $testName = null;
    /** @var int $suiteTestCurrent */
    protected $suiteTestCurrent = 0;
    /** @var int $suiteTestTotal */
    protected $suiteTestTotal = 0;
    /** @var int $testTotal */
    protected $testTotal = null;

    /**
     * @param \PHPUnit_Framework_TestResult $result
     */
    public function printResult(\PHPUnit_Framework_TestResult $result)
    {
        $this->printFooter($result);

        $this->printErrors($result);
        $this->printFailures($result);
    }

    /**
     * {@inheritdoc}
     */
    public function endTest(PHPUnit_Framework_Test $test, $time)
    {
        parent::endTest($test, $time);

        $this->executionTime = $time;
        $this->formatTestName($test);
        $this->printProgress();

        $this->suiteTestCurrent++;
    }

    /**
     * @param PHPUnit_Framework_Test $test
     */
    protected function formatTestName(PHPUnit_Framework_Test $test)
    {
        $buffer = '';
        $this->testName = $test->getName();

        if (substr($this->testName, 0, 4) == 'test') {
            $this->testName = substr($this->testName, 4);
        }

        $this->testName[0] = strtoupper($this->testName[0]);

        if (strpos($this->testName, '_') !== false) {
            $this->testName = trim(str_replace('_', ' ', $this->testName));
        }

        $max = strlen($this->testName);
        $wasNumeric = false;

        for ($i = 0; $i < $max; $i++) {
            if ($i > 0 &&
                ord($this->testName[$i]) >= 65 &&
                ord($this->testName[$i]) <= 90) {
                $buffer .= ' ' . strtolower($this->testName[$i]);
            } else {
                $isNumeric = is_numeric($this->testName[$i]);

                if (!$wasNumeric && $isNumeric) {
                    $buffer    .= ' ';
                    $wasNumeric = true;
                }

                if ($wasNumeric && !$isNumeric) {
                    $wasNumeric = false;
                }

                $buffer .= $this->testName[$i];
            }
        }

        $this->testName = $buffer;
    }

    /**
     *
     */
    protected function printProgress()
    {
        $nums = strlen($this->testTotal);

        printf(
            "  (%{$nums}d/%{$nums}d) %s %-50s (%.3fs)\n",
            $this->suiteTestCurrent,
            $this->suiteTestTotal,
            $this->testStatus,
            $this->testName,
            $this->executionTime
        );
    }

    /**
     * @param PHPUnit_Framework_TestSuite $suite
     */
    public function startTestSuite(PHPUnit_Framework_TestSuite $suite)
    {
        print "\n\033[01;36m" . $suite->getName() . "\033[0m" . ":\n";

        /**
         * Store global test num
         */
        if (is_null($this->testTotal)) {
            $this->testTotal = $suite->count();
        }

        $this->suiteTestTotal = $suite->count();
        $this->suiteTestCurrent = 1;

        parent::startTestSuite($suite);
    }

    /**
     * @param string $progress
     */
    protected function writeProgress($progress)
    {
        $this->testStatus = $this->getStatusText($progress);
    }

    /**
     * @param string $progress
     * @return string
     */
    protected function getStatusText($progress)
    {
        switch ($progress) {
            /**
             * Success
             */
            case '.':
                $status = "\033[01;32m" . mb_convert_encoding("\x27\x14", 'UTF-8', 'UTF-16BE') . "\033[0m";
                break;

            /**
             * Failed
             */
            case 'F':
            case "\033[41;37mF\033[0m":
                $status = "\033[01;31m" . mb_convert_encoding("\x27\x16", 'UTF-8', 'UTF-16BE') . "\033[0m";
                break;

            /**
             * Other cases
             */
            default:
                $status = $progress;
        }

        return $status;
    }
}
