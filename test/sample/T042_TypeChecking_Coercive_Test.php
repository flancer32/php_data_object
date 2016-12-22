<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Flancer32\Lib\Test;

/**
 * Coercive checking for types.
 *
 * @SuppressWarnings(PHPMD.CamelCaseClassName)
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 */
class T042_TypeChecking_Coercive_Test
    extends \PHPUnit_Framework_TestCase
{
    public function test_01_setterWithWrongType()
    {
        $customer = new \Flancer32\Lib\Test\Sample\TypeChecking\Customer();
        $customer->setAge('021.30');
        $this->assertTrue(is_int($customer->age));
        $this->assertEquals(21, $customer->age);
    }

}