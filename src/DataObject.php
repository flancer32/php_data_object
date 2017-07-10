<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Flancer32\Lib;

/**
 * Old-style wrapper for Universal Data Container.
 *
 * @deprecated
 * @see \Flancer32\Lib\Data
 */
class DataObject
    extends Data
    implements \IteratorAggregate
{
    /**
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->data);
    }

}