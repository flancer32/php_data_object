<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Flancer32\Lib;

class DataObject_Props_Simple_Test
    extends \PHPUnit_Framework_TestCase
{

    public function test_props()
    {
        /** === Test Data === */
        $ID = 32;
        $NAME = 'simple object';
        /** === Test itself === */
        $obj = new Sample\Props\Simple();
        $obj->id = $ID;
        $obj->name = $NAME;
        $this->assertEquals($ID, $obj->id);
        $this->assertEquals($NAME, $obj->name);
    }

}