<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Flancer32\Lib\Data;

/**
 * Empty class to create objects with various properties.
 */
class Blank
{
}

/**
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 */
class PathTest
    extends \PHPUnit_Framework_TestCase
{
    /** @var  Path */
    private $obj;

    protected function setUp()
    {
        parent::setUp();
        /** create object to test */
        $this->obj = new Path();
    }

    public function test_asArray_010_empty()
    {
        $res = $this->obj->asArray('');
        $this->assertEquals([], $res);
    }

    public function test_asArray_020_oneStep()
    {
        $res = $this->obj->asArray('path');
        $this->assertEquals(['path'], $res);
        $res = $this->obj->asArray('/path');
        $this->assertEquals(['path'], $res);
    }

    public function test_asArray_030_multiSteps()
    {
        $res = $this->obj->asArray('path/to/node');
        $this->assertEquals(['path', 'to', 'node'], $res);
        $res = $this->obj->asArray('/path/to/node');
        $this->assertEquals(['path', 'to', 'node'], $res);
        $res = $this->obj->asArray('path/to/node/');
        $this->assertEquals(['path', 'to', 'node'], $res);
        $res = $this->obj->asArray('/path/to/node/');
        $this->assertEquals(['path', 'to', 'node'], $res);
    }

    public function test_asArray_040_withArrayInside()
    {
        $res = $this->obj->asArray('path/to/0/node');
        $this->assertEquals(['path', 'to', '0', 'node'], $res);
    }

    public function test_constructor()
    {
        $this->assertInstanceOf(Path::class, $this->obj);
    }

    public function test_get_010_oneStep()
    {
        $data = new Blank();
        $data->path = 'content';
        $res = $this->obj->get($data, 'path');
        $this->assertEquals('content', $res);
    }

    public function test_get_020_multiStep()
    {
        $data = new Blank();
        $data->order = new Blank();
        $data->order->customer = new Blank();
        $data->order->customer->name = 'John Dow';
        $res = $this->obj->get($data, '/order/customer/name/');
        $this->assertEquals('John Dow', $res);
    }

    public function test_get_030_withArray()
    {
        $product1 = new Blank();
        $product1->name = 'Product 001';
        $product2 = new Blank();
        $product2->name = 'Product 002';
        $data = new Blank();
        $data->order = new Blank();
        $data->order->products[] = $product1;
        $data->order->products[] = $product2;
        $res = $this->obj->get($data, '/order/products/0/name/');
        $this->assertEquals('Product 001', $res);
        $res = $this->obj->get($data, '/order/products/1');
        $this->assertEquals('Product 002', $res->name);
    }

    public function test_set_010_oneStep_property()
    {
        $data = new Blank();
        $res = $this->obj->set($data, '/name/', 'John Dow');
        $this->assertEquals('John Dow', $res->name);
    }

    public function test_set_020_oneStep_array()
    {
        // TODO: should we replace object by array if path contains integer index?
//        $data = new Blank();
//        $res = $this->obj->set($data, '/0/', 'John Dow');
//        $this->assertEquals('John Dow', $res[0]);
    }

    public function test_set_020_multiStep_array()
    {
        $data = new Blank();
        $this->obj->set($data, '/customer/name/', 'John Dow');
        $this->assertEquals('John Dow', $data->customer->name);
    }
}