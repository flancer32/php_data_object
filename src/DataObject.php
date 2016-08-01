<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Flancer32\Lib;

/**
 * Universal Data Container.
 */
class DataObject
    implements \IteratorAggregate
{
    /** Separator for keys path elements */
    const PS = '/';

    /**#@+
     * Magic methods prefixes.
     *
     * @var string
     */
    const _METHOD_GET = 'get';
    const _METHOD_SET = 'set';
    const _METHOD_UNSET = 'unset';
    /**#@-*/

    /** @var null|array Container for data */
    private $_data = null;

    /**
     * Method 'setData(...)' is called when any argument is not null.
     *
     * @param mixed $arg1
     * @param mixed $arg2
     */
    public function __construct($arg1 = null, $arg2 = null)
    {
        if (!is_null($arg1)) {
            if (is_null($arg2)) {
                $this->setData($arg1);
            } else {
                $this->setData($arg1, $arg2);
            }
        }
    }

    /**
     * Magic method to realize getters & setters in DataObjects. Use doclet annotations in child classes
     * to annotate available methods (see http://www.phpdoc.org/docs/latest/references/phpdoc/tags/method.html)
     *
     * ATTENTION: strictly use the annotations to describe available methods, you will be thankful to yourself later.
     *
     * @param $methodName
     * @param $arguments
     *
     * @return array|null
     * @throws \Exception
     */
    public function __call($methodName, $arguments)
    {
        $result = null;
        $strlen = 3;
        $methodPrefix = substr($methodName, 0, $strlen);
        if (
            ($methodPrefix != static::_METHOD_GET) &&
            ($methodPrefix != static::_METHOD_SET)
        ) {
            $strlen = 5;
            $methodPrefix = substr($methodName, 0, $strlen);
            if ($methodPrefix != static::_METHOD_UNSET) {
                $msg = 'Invalid method ' . get_class($this) . "::$methodName(" . print_r($arguments, 1) . ')';
                throw new \Exception($msg);
            }
        }
        /* convert '[get|set|unset]AttributeName' to 'attributeName' form */
        $varName = lcfirst(substr($methodName, $strlen));
        switch ($methodPrefix) {
            case static::_METHOD_GET:
                $result = $this->getData($varName);
                break;
            case static::_METHOD_SET:
                $varValue = isset($arguments[0]) ? $arguments[0] : null;
                $this->setData($varName, $varValue);
                break;
            case static::_METHOD_UNSET:
                $this->unsetData($varName);
                break;
        }
        return $result;
    }

    /**
     * @param $path
     *
     * @return array|null
     */
    private function _getByPath($path)
    {
        $result = $this->_data;
        $keys = explode(static::PS, $path);
        $depth = count($keys);
        $level = 0;
        foreach ($keys as $key) {
            $level++;
            /* omit empty nodes (root node) */
            if ($key == '') {
                continue;
            }
            if (isset($result[$key])) {
                if (
                    ($result[$key] instanceof DataObject)
                    && ($level < $depth)
                ) {
                    /* convert nested DataObjects to array if current path element is not the last */
                    $result = $result[$key]->getData();
                } else {
                    $result = $result[$key];
                }
            } else {
                $result = null;
            }
        }
        return $result;
    }

    /**
     * @param $path
     * @param $data
     */
    private function _setByPath($path, $data)
    {
        /* init $data if is not initialized yet */
        if (is_null($this->_data)) {
            $this->_data = [];
        }
        $current = &$this->_data;
        $keys = explode(static::PS, $path);
        foreach ($keys as $key) {
            /* omit empty nodes (root node) */
            if ($key == '') {
                continue;
            }
            if (isset($current[$key])) {
                /* just go through the $data structure */
                $current = &$current[$key];
            } else {
                if (is_array($current)) {
                    /* we need to create new node on the path */
                    $current[$key] = [];
                    $current = &$current[$key];
                } else {
                    $current = [$key => []];
                    $current = &$current[$key];
                }
            }
        }
        $current = $data;
    }

    private function _unsetByPath($path)
    {
        if (!is_null($this->_data)) {
            $current = &$this->_data;
            $keys = explode(static::PS, $path);
            $count = count($keys);
            foreach ($keys as $key) {
                $count--;
                /* omit empty nodes (root node) */
                if ($key == '') {
                    continue;
                }
                if (isset($current[$key])) {
                    if ($count <= 0) {
                        /* this is the end of path, unset element in array */
                        unset($current[$key]);
                    } else {
                        /* just go through the $data structure */
                        $current = &$current[$key];
                    }
                } else {
                    /* this is un-existing path, just interrupt loop */
                    break;
                }
            }
        }
    }

    /**
     * Universal method to get data from container by path ('/object/innerObject/attribute'). Internal data container
     * ($this->_data) will be returned if $path is null.
     *
     * @param string $path
     * @param bool $underscored
     *
     * @return mixed
     */
    public function getData($path = null, $underscored = false)
    {
        if (!is_null($path) && is_array($this->_data)) {
            /* we need to find item by $path in $data array to return */
            if (strpos($path, static::PS) === false) {
                /* there is no path separator in the $path, use $path itself to get $data item */
                $key = trim($path);
                $result = isset($this->_data[$key]) ? $this->_data[$key] : null;
            } else {
                /* we need to go down to $data array structure */
                $result = $this->_getByPath($path);
            }
        } else {
            $result = $this->_data;
        }
        if ($underscored) {
            $result = $this->_convertToUnderScored($result);
        }
        return $result;
    }

    /**
     * Recursively convert DataObject to associative array with 'undescored' keys (CamelCase => under_scored).
     *
     * TODO: all converters should be external
     *
     * @param $data
     * @return array
     */
    protected function _convertToUnderScored($data)
    {
        $result = [];
        foreach ($data as $key => $item) {
            $underKey = $this->_fromCamelCase($key);
            if (is_array($item)) {
                foreach ($item as $subKey => $subItem) {
                    if (!is_int($subKey)) {
                        $subKey = $this->_fromCamelCase($subKey);
                    }
                    $subData = $this->_convertToUnderScored($subItem);
                    $result[$underKey][$subKey] = $subData;
                }
            } elseif ($item instanceof DataObject) {
                $result[$underKey] = $this->_convertToUnderScored($item->getData());
            } else {
                $result[$underKey] = $item;
            }
        }
        return $result;
    }

    /**
     * Convert CamelCase string to underscored string.
     *
     * Special thanks for 'cletus' (http://stackoverflow.com/questions/1993721/how-to-convert-camelcase-to-camel-case)
     *
     * @param string $input
     * @return string
     */
    protected function _fromCamelCase($input)
    {
        preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $input, $matches);
        $ret = $matches[0];
        foreach ($ret as &$match) {
            $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }
        return implode('_', $ret);
    }

    /**
     * If $arg2 is null then $arg2 is set as $data value,
     * otherwise $arg1 is used as $key or $path to data node (if consists '/') and $arg2 - as node value.
     *
     * $obj->set($anyDataToSet);
     * $obj->set('key_name', $anyDataToSet);
     * $obj->set('/path/to/node', $anyDataToSet);
     *
     * @param mixed $arg1
     * @param null $arg2
     *
     * @return null
     */
    public function setData($arg1, $arg2 = null)
    {
        $num = func_num_args();
        if ($num == 1) {
            /* transfer associative array data only if first arg is DataObject */
            $this->_data = ($arg1 instanceof DataObject) ? $arg1->getData() : $arg1;
        } elseif ($num == 2) {
            /* there are 2 args - key & value */
            $key = trim($arg1);
            if (strpos($key, static::PS) === false) {
                /* set data value by key */
                $this->_data[$key] = $arg2;
            } else {
                /* set data value by path */
                $this->_setByPath($key, $arg2);
            }
        }
    }

    public function unsetData($path = null)
    {
        if (is_null($path)) {
            /* unset whole root container */
            $this->_data = null;
        } elseif (
            is_array($this->_data) &&
            isset($this->_data[$path])
        ) {
            /* unset element in root container */
            unset($this->_data[$path]);
        } elseif (
            is_array($this->_data) &&
            (strpos($path, static::PS) !== false)
        ) {
            /* unset element by path */
            $this->_unsetByPath($path);
        }
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->_data);
    }
}