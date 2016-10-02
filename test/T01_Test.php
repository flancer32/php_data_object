<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Flancer32\Lib;

use Flancer32\Lib\Sample\PhpObject\Named;

/**
 * Test for PHP native objects (anonymous, named, ...).
 */
class T01_Test
    extends \PHPUnit_Framework_TestCase
{
    public function test_01_anonymous()
    {
        $obj1 = new class
        {
        };
        $obj2 = new class
        {
        };
        $obj1->name = 'first';
        $obj2->code = 'OBJ2';
        $obj1->sub = $obj2;
        $this->assertEquals('first', $obj1->name);
        $this->assertEquals('OBJ2', $obj1->sub->code);
    }

    public function test_02_named()
    {
        $obj1 = new Sample\PhpObject\Named();
        $obj2 = new Sample\PhpObject\Named();
        $obj1->name = 'first';
        $obj2->code = 'OBJ2';
        $obj1->sub = $obj2;
        $this->assertEquals('first', $obj1->name);
        $this->assertEquals('OBJ2', $obj1->sub->code);
    }

    public function test_03_structured()
    {
        $obj1 = new Sample\PhpObject\Structured();
        $obj2 = new Sample\PhpObject\Structured();
        $obj1->name = 'first';
        $obj2->code = 'OBJ2';
        $obj1->sub = $obj2;
        $this->assertEquals('first', $obj1->name);
        $this->assertEquals('OBJ2', $obj1->sub->code);
    }

    public function test_04_annotated()
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