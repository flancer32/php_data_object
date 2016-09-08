<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Flancer32\Lib;

class PhpObject_Test
    extends \PHPUnit_Framework_TestCase
{
    public function test_wo_structure()
    {
        $obj1 = new Sample\PhpObject();
        $obj2 = new Sample\PhpObject();
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
}