<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Flancer32\Lib;

use Flancer32\Lib\Sample\PhpObject\EmptyObj;

class PhpObject_Test
    extends \PHPUnit_Framework_TestCase
{
    public function test_wo_structure()
    {
        $obj1 = new Sample\PhpObject\EmptyObj();
        $obj2 = new Sample\PhpObject\EmptyObj();
        $obj1->name = 'first';
        $obj2->code = 'OBJ2';
        $obj1->sub = $obj2;
        $this->assertEquals('first', $obj1->name);
        $this->assertEquals('OBJ2', $obj1->sub->code);
    }

    public function test_with_structure()
    {
        $obj1 = new Sample\PhpObject\Annotated();
        $obj2 = new Sample\PhpObject\Annotated();
        $obj1->name = 'first';
        $obj2->code = 'OBJ2';
        $obj1->sub = $obj2;
        $this->assertEquals('first', $obj1->name);
        $this->assertEquals('OBJ2', $obj1->sub->code);
    }

    public function test_with_array()
    {
        $obj1 = new Sample\PhpObject\WithArray();
        $obj2 = new Sample\PhpObject\WithArray();
        $obj1->name = 'first';
        $obj2->code = 'OBJ2';
        //$obj1->subs[] = $obj2;
        $this->assertEquals('first', $obj1->name);
        $this->assertEquals('OBJ2', $obj1->subs[0]->code);
    }

    public function test_work()
    {
        $po = new class {};
        $po->attr1 = 21;
        $po->attr2 = 'string attr';
        $do = new DataObject($po);
        $a1 = $do->get('attr1');
    }
}