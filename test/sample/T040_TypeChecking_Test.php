<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Flancer32\Lib\Test;

/**
 * Check types of the properties.
 *
 * @SuppressWarnings(PHPMD.CamelCaseClassName)
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 */
class T040_TypeChecking_Test
    extends \PHPUnit_Framework_TestCase
{
    public function test_01_propsWithWrongType()
    {
        $customer = new \Flancer32\Lib\Test\Sample\TypeChecking\Customer();
        $customer->name = 'John Dow';
        $this->assertTrue(is_string($customer->name));
        $customer->name = 21;
        $this->assertTrue(is_int($customer->name));
    }

    public function test_02_setterWithRightType()
    {
        $customer = new \Flancer32\Lib\Test\Sample\TypeChecking\Customer();
        $customer->setName('John Dow');
        $order = new \Flancer32\Lib\Test\Sample\TypeChecking\Order();
        $order->setCustomer($customer);
        $this->assertTrue(is_string($order->getCustomer()->getName()));
    }

    /**
     * @expectedException \TypeError
     */
    public function test_03_setterWithWrongType()
    {
        $customer = new class
        {
        };
        $customer->name = 'John Dow';
        $order = new \Flancer32\Lib\Test\Sample\TypeChecking\Order();
        $order->setCustomer($customer);
    }

}