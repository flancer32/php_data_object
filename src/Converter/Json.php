<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Flancer32\Lib\Converter;

class Json
{
    /**
     * @param string $jsonString
     * @return \Flancer32\Lib\DataObject
     */
    public function from($jsonString)
    {
        $data = json_decode($jsonString, true);
        $result = new \Flancer32\Lib\DataObject($data);
        return $result;
    }

    /**
     * @param \Flancer32\Lib\DataObject $do
     * @return string
     */
    public function to(\Flancer32\Lib\DataObject $do)
    {
        $data = $do->_get();
        $result = json_encode($data);
        return $result;
    }
}