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

    public function test_construct()
    {
        /** === Test Data === */
        $KEY = 'key';
        $VALUE = 'value';
        /** === Test itself === */
        $obj = new DataObject();
        $this->assertEquals(null, $obj->_get());
        $obj = new DataObject($VALUE);
        $this->assertEquals($VALUE, $obj->_get());
        $obj = new DataObject($KEY, $VALUE);
        $this->assertEquals($VALUE, $obj->_get($KEY));
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
        $this->assertEquals(21, $obj->_get('/order/id'));
        $this->assertEquals(21, $obj->_get('order/id'));
        $this->assertEquals(32, $obj->_get('order/items/0/id'));
        $this->assertEquals(56, $obj->_get('order/items/1/id'));
    }

    public function test__set_key()
    {
        /** === Test Data === */
        $KEY = 'key';
        /** === Mocks === */
        /** === Test itself === */
        $obj = new DataObject();
        $obj->_set($KEY, 10);
        $this->assertEquals(10, $obj->_get($KEY));
        $obj->_set($KEY, 'string');
        $this->assertEquals('string', $obj->_get($KEY));
        $obj->_set($KEY, ['array']);
        $this->assertEquals(['array'], $obj->_get($KEY));
        /* use DataObject as data */
        $obj->_set($KEY, new DataObject('value'));
        $this->assertInstanceOf(DataObject::class, $obj->_get($KEY));
        $this->assertEquals('value', $obj->_get($KEY)->_get());
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
        $this->assertEquals($VAL_INT, $obj->_get('/'));
        $obj->_set('/key', $VAL_STR1);
        $this->assertEquals($VAL_STR1, $obj->_get('/key'));
        $obj->_set('/deep/path/to/node', $VAL_STR2);
        $this->assertEquals($VAL_STR2, $obj->_get('/deep/path/to/node'));
        $obj->_set('deep/path/to/node', $VAL_STR1);
        $this->assertEquals($VAL_STR1, $obj->_get('deep/path/to/node'));
        $obj->_set('path/to/node', $VAL_INT);
        $this->assertEquals($VAL_INT, $obj->_get('path/to/node'));
        $this->assertEquals($VAL_STR1, $obj->_get('/key'));
        $this->assertEquals(null, $obj->_get('/path/is/not/exist'));
    }

    public function test__set_path_nested()
    {
        $obj = new DataObject();
        /* use DataObject as data */
        $obj->_set('path/to/node', new DataObject('attr', 'value'));
        $res = $obj->_get('path/to/node/attr');
        $this->assertEquals('value', $res);
        $this->assertInstanceOf(DataObject::class, $obj->_get('path/to/node'));
    }

    public function test__set_wo_keys()
    {
        /** === Test Data === */
        /** === Mocks === */
        /** === Test itself === */
        $obj = new DataObject();
        $this->assertEquals(null, $obj->_get());
        $obj->_set(10);
        $this->assertEquals(10, $obj->_get());
        $obj->_set('string');
        $this->assertEquals('string', $obj->_get());
        $obj->_set(['array']);
        $this->assertEquals(['array'], $obj->_get());
        $obj->_set(new DataObject('key', 'value'));
        $this->assertEquals('value', $obj->_get('key'));
    }

    public function test_unsetData()
    {
        /* unset root */
        $obj = new DataObject('data');
        $this->assertEquals('data', $obj->_get());
        $obj->_unset();
        $this->assertNull($obj->_get());
        /* unset key in root array */
        $obj->setKey('dataKey');
        $obj->setOther('dataOther');
        $this->assertEquals('dataKey', $obj->getKey());
        $obj->unsetKey();
        $this->assertNull($obj->getKey());
        $this->assertEquals('dataOther', $obj->getOther());
        /* unset by path */
        $obj->_set('Other/Node', 'dataNode');
        $this->assertEquals('dataNode', $obj->_get('/Other/Node'));
        $obj->_unset('/Other/Node');
        /* wrong path */
        $obj->_unset('/Other/WrongNode');
    }
}