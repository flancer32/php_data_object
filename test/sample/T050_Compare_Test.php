<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Flancer32\Lib\Test;

/**
 * Compare object property vs. array keys.
 *
 * @SuppressWarnings(PHPMD.CamelCaseClassName)
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 */
class T050_Compare_Test
    extends \PHPUnit_Framework_TestCase
{
    const TOTAL_NODES = 1000000;
    const TOTAL_READS = 1000000;
    const TOTAL_DELETES = 1000;

    protected function setUp()
    {
        $this->markTestSkipped('This is development tests, not sample.');
    }

    public function test_010_obj()
    {
        $obj = new class
        {
        };
        $timeStart = microtime(true);
        for ($i = 0; $i < self::TOTAL_NODES; $i++) {
            $name = 'node_' . $i;
            $value = 'value_' . $i;
            $obj->$name = $value;
        }
        for ($i = 0; $i < self::TOTAL_READS; $i++) {
            $rnd = random_int(0, self::TOTAL_NODES - 1);
            $name = 'node_' . $rnd;
            $value = $obj->$name;
        }
        for ($i = 0; $i < self::TOTAL_DELETES; $i++) {
            $rnd = random_int(0, self::TOTAL_NODES - 1);
            $name = 'node_' . $rnd;
            if (isset($obj->$name)) {
                unset($obj->$name);
            }
        }
        $timeEnd = microtime(true);
        $delta = $timeEnd - $timeStart;
        echo "\nTotal: $delta.";
        $this->_logMemoryUsage();
    }

    public function test_020_arr()
    {
        $arr = [];
        $timeStart = microtime(true);
        for ($i = 0; $i < self::TOTAL_NODES; $i++) {
            $name = 'node_' . $i;
            $value = 'value_' . $i;
            $arr[$name] = $value;
        }
        for ($i = 0; $i < self::TOTAL_READS; $i++) {
            $rnd = random_int(0, self::TOTAL_NODES - 1);
            $name = 'node_' . $rnd;
            $value = $arr[$name];
        }
        for ($i = 0; $i < self::TOTAL_DELETES; $i++) {
            $rnd = random_int(0, self::TOTAL_NODES - 1);
            $name = 'node_' . $rnd;
            if (isset($arr[$name])) {
                unset($arr[$name]);
            }
        }
        $timeEnd = microtime(true);
        $delta = $timeEnd - $timeStart;
        echo "\nTotal: $delta.";
        $this->_logMemoryUsage();
    }

    protected function _logMemoryUsage()
    {
        $memPeak = number_format(memory_get_peak_usage(), 0, '.', ',');
        $memCurrent = number_format(memory_get_usage(), 0, '.', ',');
        echo("\nCurrent memory usage: $memCurrent bytes (peak: $memPeak bytes).");
    }
}