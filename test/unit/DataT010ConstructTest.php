<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Flancer32\Lib;

/**
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 */
class DataT010ConstructTest
    extends \PHPUnit_Framework_TestCase
{
    /**
     * Empty data object is equal to stdClass.
     */
    public function test_010_asEmpty()
    {
        $obj = new Data();
        $this->assertEquals(new \stdClass(), $obj->get());
    }

    public function test_020_asScalar()
    {
        $value = 32;
        $obj = new Data($value);
        $this->assertEquals($value, $obj->get());
    }

    public function test_030_asObj()
    {
        $value = new \stdClass();
        $value->prop = 'inner';
        $obj = new Data($value);
        $this->assertEquals($value, $obj->get());
    }

    public function test_040_asArr()
    {
        $value = new \stdClass();
        $value->prop = 'inner';
        $obj = new Data($value);
        $this->assertEquals($value, $obj->get());
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Wrong number of constructor arguments (should be <2).
     */
    public function test_050_exception()
    {
        new Data('arg1', 'arg2');
    }

}