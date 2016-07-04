<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Flancer32\Lib\Converter;

/**
 * Naming rules for the converter (how to convert array keys to XML/JSON nodes).
 * 'dataObjectKey' => ['DataObjectKey'|'data_object_key'|...]
 */
interface INamingStrategy
{
    /**
     * Path separator in XML path to the node.
     */
    const PS = '/';

    /**
     * @param string $key Key for DataObject/array item ('dataObjectKey')
     * @param string $path Path to the parent node ('/path/to/the/parent')
     * @return string name for XML of JSON node (DataObjectKey).
     */
    public function getNameForKey($key, $path);
}