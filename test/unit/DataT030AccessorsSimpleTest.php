<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Flancer32\Lib;

/**
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
}