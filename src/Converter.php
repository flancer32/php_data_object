<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Flancer32\Lib;

use Flancer32\Lib\Converter\INamingStrategy;

/**
 * Converter to get XML/JSON from for DataObject.
 */
class Converter
{
    /**
     * @var \Flancer32\Lib\Converter\INamingStrategy
     */
    protected $_namingStrategy;

    public function __construct(
        \Flancer32\Lib\Converter\INamingStrategy $namingStrategy = null
    ) {
        if (is_null($namingStrategy)) {
            $this->_namingStrategy = new Converter\Def\NamingStrategy();
        } else {
            $this->_namingStrategy = $namingStrategy;
        }
    }

    /**
     * @param array|DataObject $data
     * @param string $rootNode XML root node name, default - 'data'
     * @return SimpleXMLElement
     */
    public function toXml($data, $rootNode = 'data')
    {
        $result = new \SimpleXMLElement("<$rootNode></$rootNode>");
        $this->_convertToXml($data, $result);
        return $result;
    }

    /**
     * Populate $xml with entries from $data array|DataObject.
     *
     * @param DataObject|array $data
     * @param \SimpleXMLElement $xml
     */
    private function _convertToXml($data, \SimpleXMLElement &$xml, $path = '')
    {
        if ($data instanceof DataObject) {
            $data = $data->getData();
        }
        foreach ($data as $key => $value) {
            if (is_int($key)) {
                /* this is array nodes with integer indexes */
                $name = $this->_namingStrategy->getNameForKey($key, $path);
                $newPath = $path . INamingStrategy::PS . $name;
                $arrayNode = $xml->addChild($name);
                if (is_array($value)) {
                    $this->_convertToXml($value, $arrayNode, $newPath);
                } elseif ($value instanceof \Flancer32\Lib\DataObject) {
                    $this->_convertToXml($value, $arrayNode, $newPath);
                } else {
                    throw new \Exception('Data in array nodes should not be simple, array or DataObject is expected.');
                }
            } else {
                /* this is XML node, not array subnode */
                $name = $this->_namingStrategy->getNameForKey($key, $path);
                $newPath = $path . INamingStrategy::PS . $name;
                if (is_array($value)) {
                    $subnode = $xml->addChild($name);
                    $this->_convertToXml($value, $subnode, $newPath);
                } elseif ($value instanceof \Flancer32\Lib\DataObject) {
                    $subnode = $xml->addChild($name);
                    $this->_convertToXml($value, $subnode, $newPath);
                } else {
                    $xml->addChild($name, htmlspecialchars($value));
                }
            }
        }
    }


}