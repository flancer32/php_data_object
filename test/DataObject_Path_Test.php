<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Flancer32\Lib;

class DataObject_Path_UnitTest
    extends \PHPUnit_Framework_TestCase
{

    public function test_general()
    {
        /** === Test Data === */
        // @formatter:off
        $DATA = new class {};
        $OBJ = new class {};
        $SUB= new class {};
        // @formatter:on
        $DATA->obj = $OBJ;
        $OBJ->subs[] = $SUB;
        $SUB->value = 21;
        /** === Test itself === */
        $do = new DataObject($DATA);
        $val = $DATA->obj->subs[0]->value;
        $val = $do->get('/obj/subs/0/value');
    }

    public function test_missed()
    {
        /** === Test Data === */
        // @formatter:off
        $DATA = new class {};
        $OBJ = new class {};
        // @formatter:on
        $DATA->obj = $OBJ;
        $OBJ->subs = [];
        /** === Test itself === */
        $do = new DataObject($DATA);
//        $val = $DATA->obj->subs[0]->value;
        $val = $do->get('/obj/subs/0/value');
    }
}