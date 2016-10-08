<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Flancer32\Lib;

/**
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 */
class DataT020AccessSimpleTest
    extends \PHPUnit_Framework_TestCase
{
    /**
     * Empty data object is equal to stdClass.
     */
    public function test_000_construct_asEmpty()
    {
        $obj = new Data();
        $this->assertEquals(new \stdClass(), $obj->get());
    }

    public function test_002_construct_asScalar()
    {
        $value = 32;
        $obj = new Data($value);
        $this->assertEquals($value, $obj->get());
    }

    public function test_004_construct_asObj()
    {
        $value = new \stdClass();
        $value->prop = 'inner';
        $obj = new Data($value);
        $this->assertEquals($value, $obj->get());
    }

    public function test_006_construct_asArr()
    {
        $value = new \stdClass();
        $value->prop = 'inner';
        $obj = new Data($value);
        $this->assertEquals($value, $obj->get());
    }

    public function test_010_dataAsScalar()
    {
        $value = 32;
        $obj = new Data($value);
        $this->assertEquals($value, $obj->get());
    }

    public function test_020_dataAsObject()
    {
    }

    public function test_030_dataAsArray()
    {
    }

    public function test_110_simpleAccess()
    {
//        $value = 'value';
//        $obj->prop = $value;
//        $this->assertEquals($value, $obj->prop);
    }

}