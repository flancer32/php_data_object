<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Flancer32\Lib\Test;

/**
 * Test for DataObject markers (implements or extends).
 *
 * @SuppressWarnings(PHPMD.CamelCaseClassName)
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 */
class T020_Markers_Test
    extends \PHPUnit_Framework_TestCase
{
    /**
     * Data objects implement common interface.
     */
    public function test_01_implements()
    {
        $customer = new \Flancer32\Lib\Test\Sample\Marker\Impl\Customer();
        $customer->name = 'John Dow';
        $customer->email = 'jdow@gmail.com';
        $customer->age = 27;
        $product01 = new \Flancer32\Lib\Test\Sample\Marker\Impl\Product();
        $product01->name = 'Pen';
        $product01->price = 1.00;
        $product02 = new \Flancer32\Lib\Test\Sample\Marker\Impl\Product();
        $product02->name = 'Apple';
        $product02->price = 2.00;
        $order = new \Flancer32\Lib\Test\Sample\Marker\Impl\Order();
        $order->customer = $customer;
        $order->products[] = $product01;
        $order->products[] = $product02;
        $this->assertEquals('John Dow', $order->customer->name);
        $this->assertEquals('Pen', $order->products[0]->name);
        $this->assertEquals('Apple', $order->products[1]->name);
        $this->assertInstanceOf(\Flancer32\Lib\Data::class, $customer);
        $this->assertInstanceOf(\Flancer32\Lib\Data::class, $product01);
        $this->assertInstanceOf(\Flancer32\Lib\Data::class, $product02);
        $this->assertInstanceOf(\Flancer32\Lib\Data::class, $order);
    }

    /**
     * Data objects extend common parent.
     */
    public function test_01_extends()
    {
        $this->markTestSkipped('"Undefined property: stdClass::$products" is thrown.');

        $customer = new \Flancer32\Lib\Test\Sample\Marker\Ext\Customer();
        $customer->name = 'John Dow';
        $customer->email = 'jdow@gmail.com';
        $customer->age = 27;
        $product01 = new \Flancer32\Lib\Test\Sample\Marker\Ext\Product();
        $product01->name = 'Pen';
        $product01->price = 1.00;
        $product02 = new \Flancer32\Lib\Test\Sample\Marker\Ext\Product();
        $product02->name = 'Apple';
        $product02->price = 2.00;
        $order = new \Flancer32\Lib\Test\Sample\Marker\Ext\Order();
        $order->customer = $customer;
        $order->products[] = $product01;
        $order->products[] = $product02;
        $this->assertEquals('John Dow', $order->customer->name);
        $this->assertEquals('Pen', $order->products[0]->name);
        $this->assertEquals('Apple', $order->products[1]->name);
        $this->assertInstanceOf(\Flancer32\Lib\Data::class, $customer);
        $this->assertInstanceOf(\Flancer32\Lib\Data::class, $product01);
        $this->assertInstanceOf(\Flancer32\Lib\Data::class, $product02);
        $this->assertInstanceOf(\Flancer32\Lib\Data::class, $order);
        $this->assertInstanceOf(\Flancer32\Lib\Data::class, $customer);
        $this->assertInstanceOf(\Flancer32\Lib\Data::class, $product01);
        $this->assertInstanceOf(\Flancer32\Lib\Data::class, $product02);
        $this->assertInstanceOf(\Flancer32\Lib\Data::class, $order);
    }
}