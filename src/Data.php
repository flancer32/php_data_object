<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Flancer32\Lib;

require_once __DIR__ . '/Data/Path.php';

/**
 * @SuppressWarnings(PHPMD.CamelCasePropertyName)
 */
class Data
    implements IData
{
    use Data\TPath;
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
            $result = $this->_data;
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