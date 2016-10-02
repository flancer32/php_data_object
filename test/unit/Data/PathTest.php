<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Flancer32\Lib\Data;

/**
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 */
class PathTest
    extends \PHPUnit_Framework_TestCase
{
    /** @var  Path */
    private $obj;

    protected function setUp()
    {
        parent::setUp();
        /** create object to test */
        $this->obj = new Path();
    }

    public function test_constructor()
    {
        $this->assertInstanceOf(Path::class, $this->obj);
    }

    public function test_010_empty()
    {
        $res = $this->obj->asArray('');
        $this->assertEquals([], $res);
    }

    public function test_020_oneStep()
    {
        $res = $this->obj->asArray('path');
        $this->assertEquals(['path'], $res);
        $res = $this->obj->asArray('/path');
        $this->assertEquals(['path'], $res);
    }

    public function test_030_multiSteps()
    {
        $res = $this->obj->asArray('path/to/node');
        $this->assertEquals(['path', 'to', 'node'], $res);
        $res = $this->obj->asArray('/path/to/node');
        $this->assertEquals(['path', 'to', 'node'], $res);
        $res = $this->obj->asArray('path/to/node/');
        $this->assertEquals(['path', 'to', 'node'], $res);
        $res = $this->obj->asArray('/path/to/node/');
        $this->assertEquals(['path', 'to', 'node'], $res);
    }

}