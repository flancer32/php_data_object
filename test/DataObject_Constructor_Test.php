<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Flancer32\Lib;

class DataObject_Constructor_UnitTest
    extends \PHPUnit_Framework_TestCase
{

    public function test_array()
    {
        /** === Test Data === */
        $DATA = ['key' => 'value'];
        /** === Test itself === */
        $obj = new DataObject($DATA);
        $this->assertEquals($DATA, $obj->get());
    }

    public function test_empty()
    {
        /** === Test itself === */
        $obj = new DataObject();
        $this->assertEquals([], $obj->get());
    }

    public function test_null()
    {
        /** === Test Data === */
        $DATA = null;
        /** === Test itself === */
        $obj = new DataObject($DATA);
        $this->assertEquals([], $obj->get());
    }

    public function test_object()
    {
        /** === Test Data === */
        $DATA = new class
        {
        };
        $DATA->prop1 = 21;
        $DATA->prop2 = 'string';
        /** === Test itself === */
        $obj = new DataObject($DATA);
        $this->assertEquals(['prop1' => 21, 'prop2' => 'string'], $obj->get());
    }

}