<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Flancer32\Lib;

/**
 * Test 'get()' method usage.
 *
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 */
class DataT040CommonGet
    extends \PHPUnit_Framework_TestCase
{

    public function test_010_asScalar()
    {
        $value = 'value';
        $obj = new Data($value);
        $this->assertEquals($value, $obj->get());
    }

    public function test_020_byPath()
    {
//        $order = new \stdClass();
//        $customer = new \stdClass();
//        $address = new \stdClass();
//        $street = 'street';
//        $address->street = $street;
//        $customer->address = $address;
//        $order->customer = $customer;
//        $obj = new Data($order);
//        $this->assertEquals($street, $obj->get('/customer/address/street'));

    }
}