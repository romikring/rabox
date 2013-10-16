<?php
/**
 * Description of SharedLink
 *
 * @author Roman Habrusionok <romikring@gmail.com>
 */
namespace Box\Entity;

class SharedLink extends AbstractEntity
{
    static public function convertToSharedLink($link)
    {
        return new self();
    }
}
