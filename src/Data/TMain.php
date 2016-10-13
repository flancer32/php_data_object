<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Flancer32\Lib\Data;

//require_once __DIR__ . '/TPath.php';

/**
 * Main trait with protected/private methods of the ../Data class.
 *
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 */
trait TMain
{
    use TPath {
        _pathAsArray as protected;
    }

    public function _get($property)
    {
        $result = null;
        if (!$property) {
            /* return all data from inner container */
            $result = $this->_data;
        } elseif (strpos($property, static::PS) === false) {
            /* get data value by key (property name) */
            if (is_array($this->_data)) {
                $result = $this->_data[$property];
            } elseif (is_object($this->_data)) {
                $result = $this->_data->$property;
            } else {
                $result = $this->_data;
            }
        } else {
            /* get data value by path */
            $this->_getByPath($key, $value);
        }
        return $result;
    }

    public function _parseCall($name, $arguments)
    {
        $result = null;
        $length = 3; // analyze method prefix (set/get)
        $prefix = substr($name, 0, $length);
        if (
            ($prefix != 'get') &&
            ($prefix != 'set')
        ) {
            $length = 5; // analyze method prefix (unset)
            $prefix = substr($name, 0, $length);
            if ($prefix != 'unset') {
                $msg = 'Invalid method ' . get_class($this) . "::$name() for data object. get/set/unset methods are only allowed.";
                throw new \Exception($msg);
            }
        }
        /* convert '[get|set|unset]AttributeName' to 'attributeName' form */
        $property = lcfirst(substr($name, $length));
        switch ($prefix) {
            case 'get':
                $result = $this->_get($property);
                break;
            case 'set':
                $value = isset($arguments[0]) ? $arguments[0] : null;
                $this->_set($property, $value);
                break;
            case static::_METHOD_UNSET:
                $this->unset($property);
                break;
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