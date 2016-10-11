<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Flancer32\Lib\Data;

/**
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 */
trait TData
{

    public function _get($property)
    {
        $result = null;
        if (strpos($property, static::PS) === false) {
            /* get data value by key */
            if (is_array($this->_data)) {
                $result = $this->_data[$property];
            } elseif (is_object($this->_data)) {
                $result = $this->_data->$property;
            } else {
                $result = $this->_data;
            }
        } else {
            /* get data value by path */
//            $this->_setByPath($key, $value);
        }
        return $result;
    }

    public function _set($property, $value)
    {
        if (strpos($property, static::PS) === false) {
            /* set data value by key */
            if (is_array($this->_data)) {
                $this->_data[$property] = $value;
            } elseif (is_object($this->_data)) {
                $this->_data->$property = $value;
            } elseif (is_null($this->_data)) {
                $this->_data = new \stdClass();
                $this->_data->$property = $value;
            } else {
                throw new \Exception("Inner data is scalar. Cannot set property '$property'.'");
            }
        } else {
            /* set data value by path */
//            $this->_setByPath($key, $value);
        }
    }
}