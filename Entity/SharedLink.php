<?php
/**
 * Description of SharedLink
 *
 * @author Roman Habrusionok <romikring@gmail.com>
 */
namespace Box\Entity;

use Box\Entity\Incomplete\Entity;

class SharedLink extends Entity
{
    static public function convertToSharedLink($link)
    {
        return new self();
    }
}
