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
            $result = $this->data;
        } elseif (strpos($property, static::PS) === false) {
            /* get data value by key (property name) */
            if (is_array($this->data)) {
                /* try 'CamelCase' naming first */
                if (isset($this->data[$property])) {
                    $result = $this->data[$property];
                } else {
                    /* try to get 'snake_case' property */
                    $snake = $this->camelCaseToSnakeCase($property);
                    $result = isset($this->data[$snake]) ? $this->data[$snake] : null;
                }
            } elseif (is_object($this->data)) {
                /* try 'CamelCase' naming first */
                if (isset($this->data->$property)) {
                    $result = $this->data->$property;
                } else {
                    /* try to get 'snake_case' property */
                    $snake = $this->camelCaseToSnakeCase($property);
                    $result = isset($this->data->$snake) ? $this->data->$snake : null;
                }
            } else {
                $result = $this->data;
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
            $result = $this->data;
        } else {
            $pointer = $this->data;
            $level = 0;
            foreach ($steps as $step) {
                if (is_array($pointer)) {
                    if (isset($pointer[$step])) {
                        /* go to the next step */
                        $pointer = $pointer[$step];
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
                $snakeName = $this->camelCaseToSnakeCase($arg0);
                if (is_array($this->data)) {
                    /* try to set 'snake_name' if exists */
                    if (isset($this->data[$snakeName])) {
                        $this->data[$snakeName] = $value;
                    } else {
                        /* set 'CamelCase' name by default */
                        $this->data[$arg0] = $value;
                    }
                } elseif (is_object($this->data)) {
                    /* try to set 'snake_name' if exists */
                    if (isset($this->data->$snakeName)) {
                        $this->data->$snakeName = $value;
                    } else {
                        /* set 'CamelCase' name by default */
                        $this->data->$arg0 = $value;
                    }
                } elseif (is_null($this->data)) {
                    $this->data = new \stdClass();
                    /* set 'CamelCase' name by default */
                    $this->data->$arg0 = $value;
                } else {
                    throw new \Exception("Inner data is scalar. Cannot set property '$arg0'.'");
                }
            } else {
                /* set data value by path */
//            $this->_setByPath($key, $value);
            }
        } elseif (is_array($arg0)) {
            $this->data = $arg0;
        } elseif ($arg0 instanceof \Flancer32\Lib\Data) {
            $this->data = $arg0->get();
        } else {
            throw new \Exception("Some fucking shit is happened with data setting.'");
        }
    }

    public function _unset($arg0)
    {
        if (is_string($arg0)) {
            if (strpos($arg0, static::PS) === false) {
                /* unset data value by key */
                if (is_array($this->data)) {
                    unset($this->data[$arg0]);
                } elseif (is_object($this->data)) {
                    unset($this->data->$arg0);
                }
            } else {
                /* set data value by path */
//            $this->_setByPath($key, $value);
            }
        } else {
            throw new \Exception("Some fucking shit is happened with data un-setting.'");
        }
    }

    /**
     * Convert 'CamelCase' names to 'snake_case'
     *
     * https://stackoverflow.com/questions/1993721/how-to-convert-camelcase-to-camel-case
     *
     * @param string $name
     * @return string
     */
    public function camelCaseToSnakeCase($name)
    {
        preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $name, $matches);
        $ret = $matches[0];
        foreach ($ret as &$match) {
            $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }
        return implode('_', $ret);
    }
}