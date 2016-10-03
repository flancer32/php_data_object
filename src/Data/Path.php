<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Flancer32\Lib\Data;


class Path
{
    /** Separator for path elements */
    const PS = '/';

    /**
     * Convert string representation into array ('/path/to/node' => ['path', 'to', 'node']).
     *
     * @param string $path
     * @return array
     */
    public function asArray($path)
    {
        $result = explode(static::PS, $path);
        // unset empty nodes
        foreach ($result as $key => $item) {
            if (!$item && $item !== "0") {
                unset($result[$key]);
            }
        }
        // re-index array
        $result = array_values($result);
        return $result;
    }

    /**
     * Get object property by path.
     *
     * @param $obj
     * @param $path
     * @return mixed|null
     */
    public function get($obj, $path)
    {
        $result = null;
        $parts = $this->asArray($path);
        $buffer = $obj;
        $depth = count($parts); // number of parts in the path
        $level = 0; // current level in the path
        foreach ($parts as $part) {
            $level++;
            if (isset($buffer->$part)) {
                /* $buffer is object */
                if ($level == $depth) {
                    // this is target property, set result and end the loop
                    $result = $buffer->$part;
                } else {
                    $buffer = $buffer->$part;
                }
            } elseif (isset($buffer[$part])) {
                /* $buffer is array */
                if ($level == $depth) {
                    // this is target property, set result and end the loop
                    $result = $buffer[$part];
                } else {
                    $buffer = $buffer[$part];
                }
            } else {
                /* current property does not exist, break and return 'null' */
                $result = null;
                break;
            }
        }
        return $result;
    }

    public function set(&$obj, $path, $value)
    {
        $parts = $this->asArray($path);
        $buffer = $obj;
        $depth = count($parts); // number of parts in the path
        $level = 0; // current level in the path
        foreach ($parts as $part) {
            $level++;
            if (isset($buffer->$part)) {
                /* $buffer is object */
                if ($level == $depth) {
                    $buffer->$part = $value; // this is target property, set value and exit
                } else {
                    $buffer = $buffer->$part; // move one level down (object)
                }
            } elseif (is_array($buffer) && isset($buffer[$part])) {
                /* $buffer is array */
                if ($level == $depth) {
                    $buffer[$part] = $value; // this is target property, set value and exit
                } else {
                    $buffer = $buffer[$part];  // move one level down (array)
                }
            } else {
                /* current property does not exist, create new object and move buffer one step down */
                $buffer->$part = new class
                {
                };
                if ($level == $depth) {
                    /* assign $value to the new property */
                    $buffer->$part = $value;
                } else {
                    /* move buffer one step down */
                    $buffer = $buffer->$part;
                }
            }
        }
    }
}