<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Flancer32\Lib;

/**
 * @method mixed get(string $path = null) get inner container data all or by path.
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
        if ($name == 'get') {
            /* getter for container's inner data */
            $propertyPath = isset($arguments[0]) ? $arguments[0] : null;
            $result = $this->_get($propertyPath);
        } elseif ($name == 'set') {
            /* setter for container's inner data */
            $this->_data = $arguments;
        } elseif ($name == 'unset') {
            /* unset container's inner data; empty container is stdClass */
            $this->_data = new \stdClass();
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
        if (isset($this->_data->$name)) {
            $result = $this->_data->$name;
        } elseif (is_array($this->_data) && isset($this->_data[$name])) {
            $result = $this->_data[$name];
        }
        return $result;
    }

    /**
     * Magic method to write properties directly.
     *
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        if (is_object($this->_data)) {
            $this->_data->$name = $value;
        } elseif (is_array($this->_data)) {
            $this->_data[$name] = $value;
        } else {
            throw new \Exception('Inner container is not object or array. Cannot set property ' . "'$name'.");
        }

    }

    public function __unset($name)
    {
        if (isset($this->_data->$name)) {
            unset($this->_data->$name);
        }
        if (isset($this->_data[$name])) {
            unset($this->_data[$name]);
        }
    }
}