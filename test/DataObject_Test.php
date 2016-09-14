<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Flancer32\Lib;

class DataObject_UnitTest
    extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \Exception
     */
    public function test_call_exception()
    {
        /** === Test Data === */
        /** === Mocks === */
        /** === Test itself === */
        $obj = new DataObject();
        $obj->callUnknownMethod();
    }

    public function test_construct_empty()
    {
        /** === Test itself === */
        $obj = new DataObject();
        $this->assertEquals([], $obj->get());
    }

    public function test_construct_null()
    {
        /** === Test Data === */
        $DATA = null;
        /** === Test itself === */
        $obj = new DataObject($DATA);
        $this->assertEquals([], $obj->get());
    }

    public function test_construct_array()
    {
        /** === Test Data === */
        $DATA = ['key' => 'value'];
        /** === Test itself === */
        $obj = new DataObject($DATA);
        $this->assertEquals($DATA, $obj->get());
    }

    public function test_construct_object()
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

    public function test_construct_fromArray()
    {
        /** === Test Data === */
        $DATA = [
            'order' => [
                'id' => 21,
                'items' => [
                    ['id' => 32],
                    ['id' => 56]
                ]
            ]
        ];
        /** === Test itself === */
        $obj = new DataObject($DATA);
        $this->assertEquals(21, $obj->get('/order/id'));
        $this->assertEquals(21, $obj->get('order/id'));
        $this->assertEquals(32, $obj->get('order/items/0/id'));
        $this->assertEquals(56, $obj->get('order/items/1/id'));
    }

    public function test__set_key()
    {
        /** === Test Data === */
        $KEY = 'key';
        /** === Mocks === */
        /** === Test itself === */
        $obj = new DataObject();
        $obj->_set($KEY, 10);
        $this->assertEquals(10, $obj->get($KEY));
        $obj->_set($KEY, 'string');
        $this->assertEquals('string', $obj->get($KEY));
        $obj->_set($KEY, ['array']);
        $this->assertEquals(['array'], $obj->get($KEY));
        /* use DataObject as data */
        $obj->_set($KEY, new DataObject('value'));
        $this->assertInstanceOf(DataObject::class, $obj->get($KEY));
        $this->assertEquals('value', $obj->get($KEY)->_get());
    }

    public function test__set_path()
    {
        /** === Test Data === */
        $VAL_INT = 10;
        $VAL_STR1 = 'string';
        $VAL_STR2 = 'more string';
        /** === Mocks === */
        /** === Test itself === */
        $obj = new DataObject();
        $obj->_set('/', $VAL_INT);
        $this->assertEquals($VAL_INT, $obj->get('/'));
        $obj->_set('/key', $VAL_STR1);
        $this->assertEquals($VAL_STR1, $obj->get('/key'));
        $obj->_set('/deep/path/to/node', $VAL_STR2);
        $this->assertEquals($VAL_STR2, $obj->get('/deep/path/to/node'));
        $obj->_set('deep/path/to/node', $VAL_STR1);
        $this->assertEquals($VAL_STR1, $obj->get('deep/path/to/node'));
        $obj->_set('path/to/node', $VAL_INT);
        $this->assertEquals($VAL_INT, $obj->get('path/to/node'));
        $this->assertEquals($VAL_STR1, $obj->get('/key'));
        $this->assertEquals(null, $obj->get('/path/is/not/exist'));
    }

    public function test__set_path_nested()
    {
        $obj = new DataObject();
        /* use DataObject as data */
        $obj->_set('path/to/node', new DataObject('attr', 'value'));
        $res = $obj->get('path/to/node/attr');
        $this->assertEquals('value', $res);
        $this->assertInstanceOf(DataObject::class, $obj->get('path/to/node'));
    }

    public function test__set_wo_keys()
    {
        /** === Test Data === */
        /** === Mocks === */
        /** === Test itself === */
        $obj = new DataObject();
        $this->assertEquals(null, $obj->get());
        $obj->_set(10);
        $this->assertEquals(10, $obj->get());
        $obj->_set('string');
        $this->assertEquals('string', $obj->get());
        $obj->_set(['array']);
        $this->assertEquals(['array'], $obj->get());
        $obj->_set(new DataObject('key', 'value'));
        $this->assertEquals('value', $obj->get('key'));
    }

    public function test_unsetData()
    {
        /* unset root */
        $obj = new DataObject('data');
        $this->assertEquals('data', $obj->get());
        $obj->_unset();
        $this->assertNull($obj->get());
        /* unset key in root array */
        $obj->setKey('dataKey');
        $obj->setOther('dataOther');
        $this->assertEquals('dataKey', $obj->getKey());
        $obj->unsetKey();
        $this->assertNull($obj->getKey());
        $this->assertEquals('dataOther', $obj->getOther());
        /* unset by path */
        $obj->_set('Other/Node', 'dataNode');
        $this->assertEquals('dataNode', $obj->get('/Other/Node'));
        $obj->_unset('/Other/Node');
        /* wrong path */
        $obj->_unset('/Other/WrongNode');
    }
}