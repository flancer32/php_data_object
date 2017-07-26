<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Flancer32\Lib;

/**
 * Test 'get()' method usage with 'snake_case' naming strategy.
 *
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 */
class DataT050SnakeCaseGetTest
    extends \PHPUnit_Framework_TestCase
{

    /**
     * Get 'snake_named' property using 'CamelCase' naming (array).
     */
    public function test_010_getSnakeValueByCamelName()
    {
        $value = ['some_prop' => 10];
        $obj = new Data($value);
        $this->assertEquals(10, $obj->getSomeProp());
    }

    /**
     * Return 'someProp' value if 'some_prop' exists (array).
     */
    public function test_020_getCamelValueWhenSnakeValueExists()
    {
        $value = ['some_prop' => 10, 'someProp' => 20];
        $obj = new Data($value);
        $this->assertEquals(20, $obj->getSomeProp());
    }

    /**
     * Return 'some_prop' value if 'someProp' exists (array).
     */
    public function test_030_getSnakeValueWhenCamelValueExists()
    {
        $value = ['some_prop' => 10, 'someProp' => 20];
        $obj = new Data($value);
        $this->assertEquals(10, $obj->get('some_prop'));
    }

    /**
     * Get 'snake_named' property using 'CamelCase' naming (object).
     */
    public function test_040_getSnakeValueByCamelName()
    {
        $value = new \stdClass();
        $value->some_prop = 10;
        $obj = new Data($value);
        $this->assertEquals(10, $obj->getSomeProp());
    }

    /**
     * Return 'someProp' value if 'some_prop' exists (object).
     */
    public function test_050_getCamelValueWhenSnakeValueExists()
    {
        $value = new \stdClass();
        $value->some_prop = 10;
        $value->someProp = 20;
        $obj = new Data($value);
        $this->assertEquals(20, $obj->getSomeProp());
    }

    /**
     * Return 'some_prop' value if 'someProp' exists (object).
     */
    public function test_060_getSnakeValueWhenCamelValueExists()
    {
        $value = new \stdClass();
        $value->some_prop = 10;
        $value->someProp = 20;
        $obj = new Data($value);
        $this->assertEquals(10, $obj->get('some_prop'));
    }

}