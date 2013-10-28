<?php
/**
 * Description of Enterprise
 *
 * @author Roman Habrusionok <romikring@gmail.com>
 */
namespace Box\Storage;

use Box\Entity\Incomplete\Entity as BaseEntity;

class Entity
{
    /**
     * Object container
     *
     * @var array
     */
    private $_storage;

    /**
     * The constructor
     */
    public function __construct()
    {
        $this->detachAll();
    }

    /**
     * Returns object's unique key
     *
     * @param \Box\Entity\Incomplete\Entity $entity Entity object
     *
     * @return string
     */
    public function getHash(BaseEntity $entity)
    {
        return sprintf('%s-%s', $entity->getType(), $entity->getId());
    }

    /**
     *
     * @param \Box\Entity\Incomplete\Entity $entity
     *
     * @return boolean
     */
    public function contains(BaseEntity $entity)
    {
        return isset($this->_storage[$this->getHash($entity)]);
    }

    /**
     * Adds object to storage
     *
     * @param \Box\Entity\Incomplete\Entity $entity
     *
     * @throws Exception
     *
     * @return \Box\Storage\Entity
     */
    public function attach(BaseEntity $entity)
    {
        if ($this->contains($entity)) {
            throw new Exception('You are trying to attach object that\'s already attached');
        }

        $this->_storage[$this->getHash($entity)] = $entity;

        return $this;
    }

    /**
     * Removes object from storage
     *
     * @param \Box\Entity\Incomplete\Entity $entity
     *
     * @return \Box\Storage\Entity
     */
    public function detach(BaseEntity $entity)
    {
        unset($this->_storage[$this->getHash($entity)]);

        return $this;
    }

    /**
     * Purge the storage
     *
     * @return \Box\Storage\Entity
     */
    public function detachAll()
    {
        $this->_storage = array();

        return $this;
    }

    /**
     * Update old or insert new entity to the storage
     *
     * @param \Box\Entity\Incomplete\Entity $entity
     *
     * @return \Box\Storage\Entity
     */
    public function update(BaseEntity $entity)
    {
        $this->_storage[$this->getHash($entity)] = $entity;

        return $this;
    }

    /**
     * Count objects in the storage
     *
     * @return integer
     */
    public function count()
    {
        return \count($this->_storage);
    }

    /**
     * Returns Entity object from storage or False otherwise
     *
     * @param \Box\Entity\Incomplete\Entity $entity
     *
     * @throws Exception
     *
     * @return \Box\Entity\Incomplete\Entity | NULL
     */
    public function find($entity)
    {
        if ($entity instanceof BaseEntity) {
            $hash = $this->getHash($entity);
        } elseif (is_string($entity)) {
            $hash = $entity;
        } else {
            throw new Exception('You have to set hash string or Entity object as this method argument');
        }

        return isset($this->_storage[$hash]) ? $this->_storage[$hash] : FALSE;
    }
}
