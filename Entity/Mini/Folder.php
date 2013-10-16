<?php
/**
 * Description of Folder
 *
 * @author Roman Habrusionok <romikring@gmail.com>
 */
namespace Box\Entity\Mini;

/**
 * Mini folder class
 */
class Folder extends AbstractMini
{
    static public function convertToMiniFolder($folder)
    {
        return static::convertToTarget($folder);
    }
}
