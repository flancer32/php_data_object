<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Flancer32\Lib\Data;

use Flancer32\Lib\Config as Cfg;

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
                $result = isset($this->_data[$property]) ? $this->_data[$property] : null;
            } elseif (is_object($this->_data)) {
                $result = isset($this->_data->$property) ? $this->_data->$property : null;
            } else {
                $result = $this->_data;
            }
        } else {
            /* get data value by path */
            $result = $this->_getByPath($property);
        }
        return $result;
    }

    /**
     * Recursive method to get some attribute of the DataObject by path.
     *
     * @param $path
     * @return array|\Flancer32\Lib\IData|mixed|null
     */
    public function _getByPath($path)
    {
        $result = null;
        $steps = $this->_pathAsArray($path);
        $depth = count($steps); // number of steps in the path
        if ($depth == 0) {
            $result = $this->_data;
        } else {
            $pointer = $this->_data;
            $level = 0;
            foreach ($steps as $step) {
                if (is_array($pointer)) {
                    if (isset($pointer[ $step ])) {
                        /* go to the next step */
                        $pointer = $pointer[ $step ];
                    } else {
                        /* next step is missed in the path, return null */
                        break;
                    }
                } elseif ($pointer instanceof \Flancer32\Lib\IData) {
                    if (!is_null($pointer->get($step))) {
                        /* go to the next step */
                        $pointer = $pointer->get($step);
                    } else {
                        /* next step is missed in the path, return null */
                        break;
                    }
                } elseif (is_object($pointer)) {
                    if (isset($pointer->$step)) {
                        /* go to the next step */
                        $pointer = $pointer->$step;
                    } else {
                        /* next step is missed in the path, return null */
                        break;
                    }
                } else {
                    /* we have no data for the next step */
                    break;
                }
                $level++; // one step on the path is done
            }
            if ($level >= $depth) {
                /* we have reached the end of path */
                $result = $pointer;
            }
        }
        return $result;
    }

    public function _parseCall($name, $arguments)
    {
        $result = null;
        $length = 3; // analyze method prefix (set/get)
        $prefix = substr($name, 0, $length);
        if (
            ($prefix != Cfg::METHOD_GET) &&
            ($prefix != Cfg::METHOD_SET)
        ) {
            $length = 5; // analyze method prefix (unset)
            $prefix = substr($name, 0, $length);
            if ($prefix != Cfg::METHOD_UNSET) {
                $msg = 'Invalid method ' . get_class($this) . "::$name() for data object. get/set/unset methods are only allowed.";
                throw new \Exception($msg);
            }
        }
        /* convert '[get|set|unset]AttributeName' to 'attributeName' form */
        $property = lcfirst(substr($name, $length));
        switch ($prefix) {
            case Cfg::METHOD_GET:
                $result = $this->_get($property);
                break;
            case Cfg::METHOD_SET:
                $value = isset($arguments[0]) ? $arguments[0] : null;
                $this->_set($property, $value);
                break;
            case Cfg::METHOD_UNSET:
                $this->unset($property);
                break;
        }
        return $result;
    }

    public function _set($arg0, $value)
    {
        if (is_string($arg0)) {
            if (strpos($arg0, static::PS) === false) {
                /* set data value by key */
                if (is_array($this->_data)) {
                    $this->_data[$arg0] = $value;
                } elseif (is_object($this->_data)) {
                    $this->_data->$arg0 = $value;
                } elseif (is_null($this->_data)) {
                    $this->_data = new \stdClass();
                    $this->_data->$arg0 = $value;
                } else {
                    throw new \Exception("Inner data is scalar. Cannot set property '$arg0'.'");
                }
            } else {
                /* set data value by path */
//            $this->_setByPath($key, $value);
            }
        } elseif (is_array($arg0)) {
            $this->_data = $arg0;
        } elseif ($arg0 instanceof \Flancer32\Lib\Data) {
            $this->_data = $arg0->get();
        } else {
            throw new \Exception("Some fucking shit is happened with data setting.'");
        }
    }

    public function _unset($arg0)
    {
        if (is_string($arg0)) {
            if (strpos($arg0, static::PS) === false) {
                /* unset data value by key */
                if (is_array($this->_data)) {
                    unset($this->_data[$arg0]);
                } elseif (is_object($this->_data)) {
                    unset($this->_data->$arg0);
                }
            } else {
                /* set data value by path */
//            $this->_setByPath($key, $value);
            }
        } else {
            throw new \Exception("Some fucking shit is happened with data un-setting.'");
        }
    }
}