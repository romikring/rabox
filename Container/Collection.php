<?php
/**
 * Description of Collection
 *
 * @author romik
 */
namespace Box\Container;

class Collection extends \ArrayObject
{
    static public function convertToCollection($collection)
    {
        return new self();
    }
}
