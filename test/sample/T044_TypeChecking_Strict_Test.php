<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
declare(strict_types = 1);
namespace Flancer32\Lib\Test;

/**
 * Strict checking for types.
 *
 * @SuppressWarnings(PHPMD.CamelCaseClassName)
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 */
class T044_TypeChecking_Strict_Test
    extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \TypeError
     */
    public function test_01_setterWithWrongType()
    {
        $customer = new \Flancer32\Lib\Test\Sample\TypeChecking\Customer();
        $customer->setAge('21');
    }

}