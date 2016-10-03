<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Flancer32\Lib;

/**
 * Path to node.
 *
 * @SuppressWarnings(PHPMD.CamelCaseClassName)
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 */
class T030_Path_Test
    extends \PHPUnit_Framework_TestCase
{
    /**
     * Data objects implement common interface.
     */
    public function test_01_simple()
    {
        $customer = new \Flancer32\Lib\Sample\Marker\Impl\Customer();
        $customer->name = 'John Dow';
        $order = new \Flancer32\Lib\Sample\Marker\Impl\Order();
        $order->customer = $customer;

    }
}