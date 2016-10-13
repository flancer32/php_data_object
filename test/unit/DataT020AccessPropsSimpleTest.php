<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Flancer32\Lib;

/**
 * Access properties of the data object directly.
 *
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 */
class DataT020AccessPropsSimpleTest
    extends \PHPUnit_Framework_TestCase
{


    public function test_010_asScalar()
    {
        $name = 'property';
        $value = 'value';
        $obj = new Data();
        $obj->$name = $value;
        $this->assertEquals($value, $obj->$name);
    }

    public function test_020_asObj()
    {
        $name = 'property';
        $value = new \stdClass();
        $obj = new Data();
        $obj->$name = $value;
        $this->assertEquals($value, $obj->$name);
    }

    public function test_030_asArray()
    {
        $name = 'property';
        $value = ['value'];
        $obj = new Data();
        $obj->$name = $value;
        $this->assertEquals($value, $obj->$name);
    }

    public function test_040_asDataObject()
    {
        $name = 'property';
        $value = new Data('value');
        $obj = new Data();
        $obj->$name = $value;
        $this->assertEquals($value, $obj->$name);
    }

}