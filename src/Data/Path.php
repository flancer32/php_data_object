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
            if (!$item) {
                unset($result[ $key ]);
            }
        }
        // re-index array
        $result = array_values($result);
        return $result;
    }
}