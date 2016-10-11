<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Flancer32\Lib;

require_once __DIR__ . '/Data/TData.php';
require_once __DIR__ . '/Data/Path.php';

/**
 * @SuppressWarnings(PHPMD.CamelCasePropertyName)
 */
class Data
    implements IData
{
    use Data\TPath;
    use Data\TData {
        _get as protected;
        _set as protected;
    }

    /** Separator for path elements */
    const PS = '/';

    /** @var mixed Container for data. */
    protected $_data;

    public function __construct()
    {
        $argc = func_num_args();
        if ($argc == 0) {
            // empty DataObject is just an \stdClass
            $this->_data = new \stdClass();
        } elseif ($argc == 1) {
            // store first argument as storage content
            $this->_data = func_get_arg(0);
        } else {
            throw new \Exception('Wrong number of constructor arguments (should be <2).');
        }
    }

    public function __call($name, $arguments)
    {
        $result = null;
        if ($name == 'get') {
            /* getter for container's inner data */
            $result = $this->_data;
        } elseif ($name == 'set') {
            /* setter for container's inner data */
        } elseif ($name == 'unset') {
            /* unset container's inner data */
        } else {
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
        }
        return $result;
    }

    public function __get($name)
    {
        $result = $this->_data->$name;
        return $result;
    }

    public function __set($name, $value)
    {
        $this->_data->$name = $value;
    }

    public function __unset($name)
    {
        if (isset($this->_data->$name)) {
            unset($this->_data->$name);
        }
    }
}