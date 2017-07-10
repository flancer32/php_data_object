<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Flancer32\Lib;

use Flancer32\Lib\Config as Cfg;

/**
 * @method mixed get(mixed $path = null) get inner container data (all or by path).
 * @method null set(mixed $pathOrValue = null, mixed $value = null) set inner container data (all or by path).
 *
 * @SuppressWarnings(PHPMD.CamelCasePropertyName)
 */
class Data
    implements IData
{
    use Data\TMain {
        _get as protected;
        _getByPath as protected;
        _parseCall as protected;
        _set as protected;
        _unset as protected;
    }

    /** Separator for path elements */
    const PS = '/';

    /** @var mixed Container for data. */
    protected $data;

    public function __construct()
    {
        $argc = func_num_args();
        if ($argc == 0) {
            // empty DataObject is just an \stdClass
            $this->data = new \stdClass();
        } elseif ($argc == 1) {
            // store first argument as storage content if it is not 'null'.
            $first = func_get_arg(0);
            if (is_null($first)) {
                $this->data = new \stdClass();
            } else {
                $this->data = func_get_arg(0);
            }
        } else {
            throw new \Exception('Wrong number of constructor arguments (should be <2).');
        }
    }

    /**
     * Magic method for all other methods (accessors, etc.).
     *
     * @param string $name method name
     * @param $arguments
     * @return mixed|null
     */
    public function __call($name, $arguments)
    {
        $result = null;
        $propertyPath = isset($arguments[0]) ? $arguments[0] : null;
        if ($name == Cfg::METHOD_GET) {
            /* getter for container's inner data */
            /* return $_data if get() w/o path or return data by path */
            $result = $this->_get($propertyPath);
        } elseif ($name == Cfg::METHOD_SET) {
            /* setter for container's inner data */
            $value = isset($arguments[1]) ? $arguments[1] : null;
            $result = $this->_set($propertyPath, $value);
        } elseif ($name == Cfg::METHOD_UNSET) {
            /* unset container's inner data; empty container is stdClass */
            $this->_unset($propertyPath);
        } else {
            $result = $this->_parseCall($name, $arguments);
        }
        return $result;
    }

    /**
     * Magic method to read properties directly.
     *
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        $result = null;
        if (isset($this->data->$name)) {
            $result = $this->data->$name;
        } elseif (is_array($this->data) && isset($this->data[$name])) {
            $result = $this->data[$name];
        }
        return $result;
    }

    /**
     * Magic method to write properties directly.
     *
     * @param $name
     * @param $value
     * @throws \Exception
     */
    public function __set($name, $value)
    {
        if (is_object($this->data)) {
            $this->data->$name = $value;
        } elseif (is_array($this->data)) {
            $this->data[$name] = $value;
        } else {
            throw new \Exception('Inner container is not object or array. Cannot set property ' . "'$name'.");
        }

    }

    public function __unset($name)
    {
        if (isset($this->data->$name)) {
            unset($this->data->$name);
        }
        if (isset($this->data[$name])) {
            unset($this->data[$name]);
        }
    }
}