<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Flancer32\Lib\Converter;

class Json
{
    /**
     * @param string $jsonString
     * @return \Flancer32\Lib\Data
     */
    public function from($jsonString)
    {
        $data = json_decode($jsonString, true);
        $result = new \Flancer32\Lib\Data($data);
        return $result;
    }

    /**
     * @param \Flancer32\Lib\Data $do
     * @return string
     */
    public function to(\Flancer32\Lib\Data $do)
    {
        $data = $do->get();
        $result = json_encode($data);
        return $result;
    }
}