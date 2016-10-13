<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Flancer32\Lib;

/**
 * Access properties of the data object using accessors (getters & setters).
 *
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 */
class DataT030AccessorsSimpleTest
    extends \PHPUnit_Framework_TestCase
{

    public function test_010_asScalar()
    {
        $value = 'value';
        $obj = new Data();
        $obj->setProperty($value);
        $this->assertEquals($value, $obj->getProperty());
    }

    public function test_020_asObj()
    {
        $value = new class
        {
            public $prop = 32;
        };
        $obj = new Data();
        $obj->setProperty($value);
        $this->assertEquals(32, $obj->getProperty()->prop);
    }

    public function test_030_asArr()
    {
        $value = ['prop' => 64];
        $obj = new Data();
        $obj->setProperty($value);
        $this->assertEquals(64, $obj->getProperty()['prop']);
    }
}