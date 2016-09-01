<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Flancer32\Lib;

class DataObject_Get_UnitTest
    extends \PHPUnit_Framework_TestCase
{

    public function test_props()
    {
        /** === Test Data === */
        $ID = 32;
        $NAME = 'simple object';
        /** === Test itself === */
        $obj = new DtoSimple();
        $obj->id = $ID;
        $obj->name = $NAME;
        $this->assertEquals($ID, $obj->id);
        $this->assertEquals($NAME, $obj->name);
    }

}

/**
 * Object with simple properties to test.
 *
 * @property int $id Object's ID.
 * @property string $name Object's name.
 */
class DtoSimple extends \Flancer32\Lib\DataObject
{
}