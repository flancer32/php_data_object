<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Flancer32\Lib;

class DataObject_UnitTest extends \PHPUnit_Framework_TestCase {
    public function test_construct() {
        /** === Test Data === */
        $VAL = 'value';
        /** === Mocks === */
        /** === Test itself === */
        $obj = new DataObject($VAL, null);
        $this->assertEquals($VAL, $obj->getData());
    }

    /**
     * @expectedException \Exception
     */
    public function test_call_exception() {
        /** === Test Data === */
        /** === Mocks === */
        /** === Test itself === */
        $obj = new DataObject();
        $obj->callUnknownMethod();
    }

    public function test_setData_wo_keys() {
        /** === Test Data === */
        /** === Mocks === */
        /** === Test itself === */
        $obj = new DataObject();
        $this->assertEquals(null, $obj->getData());
        $obj->setData(10);
        $this->assertEquals(10, $obj->getData());
        $obj->setData('string');
        $this->assertEquals('string', $obj->getData());
        $obj->setData([ 'array' ]);
        $this->assertEquals([ 'array' ], $obj->getData());
        $obj->setData(new DataObject('key', 'value'));
        $this->assertEquals('value', $obj->getData('key'));
    }

    public function test_setData_key() {
        /** === Test Data === */
        $KEY = 'key';
        /** === Mocks === */
        /** === Test itself === */
        $obj = new DataObject();
        $obj->setData($KEY, 10);
        $this->assertEquals(10, $obj->getData($KEY));
        $obj->setData($KEY, 'string');
        $this->assertEquals('string', $obj->getData($KEY));
        $obj->setData($KEY, [ 'array' ]);
        $this->assertEquals([ 'array' ], $obj->getData($KEY));
        /* use DataObject as data */
        $obj->setData($KEY, new DataObject('value'));
        $this->assertEquals('value', $obj->getData($KEY));
    }

    public function test_setData_path() {
        /** === Test Data === */
        $VAL_INT = 10;
        $VAL_STR1 = 'string';
        $VAL_STR2 = 'more string';
        /** === Mocks === */
        /** === Test itself === */
        $obj = new DataObject();
        $obj->setData('/', $VAL_INT);
        $this->assertEquals($VAL_INT, $obj->getData('/'));
        $obj->setData('/key', $VAL_STR1);
        $this->assertEquals($VAL_STR1, $obj->getData('/key'));
        $obj->setData('/deep/path/to/node', $VAL_STR2);
        $this->assertEquals($VAL_STR2, $obj->getData('/deep/path/to/node'));
        $obj->setData('deep/path/to/node', $VAL_STR1);
        $this->assertEquals($VAL_STR1, $obj->getData('deep/path/to/node'));
        $obj->setData('path/to/node', $VAL_INT);
        $this->assertEquals($VAL_INT, $obj->getData('path/to/node'));
        $this->assertEquals($VAL_STR1, $obj->getData('/key'));
        $this->assertEquals(null, $obj->getData('/path/is/not/exist'));
        /* use DataObject as data */
        $obj->setData('path/to/node', new DataObject('attr', 'value'));
        $this->assertEquals('value', $obj->getData('path/to/node/attr'));
    }

}