<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Flancer32\Lib;

/**
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 */
class DataTest
    extends \PHPUnit_Framework_TestCase
{
    /**
     * Empty data object is equal to stdClass.
     */
    public function test_000_createAsEmpty()
    {
        $obj = new Data();
        $this->assertEquals(new \stdClass(), $obj->get());
    }

    public function test_002_createAsScalar()
    {
        $value = 32;
        $obj = new Data($value);
        $this->assertEquals($value, $obj->get());
    }

    public function test_004_createAsObj()
    {
        $value = new \stdClass();
        $value->prop = 'inner';
        $obj = new Data($value);
        $this->assertEquals($value, $obj->get());
    }

    public function test_006_createAsArr()
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