<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Flancer32\Lib\Data;

/**
 * Trait with methods that operate with path.
 *
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 */
trait TPath
{
    /**
     * Convert string representation into array ('/path/to/node' => ['path', 'to', 'node']).
     *
     * @param string $path
     * @return array
     */
    public function _pathAsArray($path)
    {
        $result = explode(self::PS, $path);
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

}