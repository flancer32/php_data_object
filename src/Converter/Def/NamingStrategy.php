<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Flancer32\Lib\Converter\Def;

use Flancer32\Lib\Converter\DataObject;

/**
 * 'no conversation' strategy is the default implementation of the Naming Strategy ('keyName' => 'keyName').
 */
class NamingStrategy
    implements \Flancer32\Lib\Converter\INamingStrategy
{

    /** @inheritdoc */
    public function getNameForKey($key, $path)
    {
        return $$key;
    }
}