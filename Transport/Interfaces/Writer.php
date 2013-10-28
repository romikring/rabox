<?php
/**
 * Description of Enterprise
 *
 * @author Roman Habrusionok <romikring@gmail.com>
 */
namespace Box\Transport\Interfaces;

use Box\Entity\Incomplete\Entity;

interface Writer
{
    /**
     * Save or update some entity
     */
    public function upload(Entity $entity);
}
