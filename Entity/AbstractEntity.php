<?php
/**
 * Description of Entity
 *
 * @author Roman Habrusionok <romikring@gmail.com>
 */
namespace Box\Entity;

abstract class AbstractEntity extends Mini\AbstractMini
{
    const ENTITY_TYPE = null;

    /**
     * A unique string identifying this entity
     *
     * @var string
     */
    protected $id;
    /**
     * The time this entity was created
     *
     * @var \DateTime
     */
    protected $createdAt;
    /**
     * Is this User instance mini object?
     *
     * @var boolean
     */
    private $_mini = false;
    /**
     * Is this user
     * @var boolean
     */
    private $_dirty = false;

    public function isMini()
    {
        return $this->_mini;
    }

    public function markAsMini($isMini = true)
    {
        $this->_mini = (boolean) $isMini;

        return $this;
    }

    public function isDirty()
    {
        return $this->_dirty;
    }

    /**
     * Mark current entity as dirty and required be synced
     *
     * @param boolean $isDirty Dirty flag, True by default
     *
     * @return \Box\Entity\AbstractEntity
     */
    public function markDirty($isDirty = true)
    {
        $this->_dirty = (boolean) $isDirty;

        return $this;
    }

    /**
     * Returns entity's type
     *
     * @return string
     */
    public function getType()
    {
        return static::ENTITY_TYPE;
    }

    /**
     * Sets ID
     *
     * @param string $id ID
     *
     * @return \Box\Entity\AbstractEntity
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Returns ID
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets create_at timestamp
     *
     * @param string $timestamp Timestamp
     *
     * @return \Box\Entity\AbstractEntity
     */
    public function setCreatedAt($timestamp)
    {
        $this->createdAt = $this->_convertToDateTime($timestamp);

        return $this;
    }

    /**
     * Returns create_at DateTime object
     *
     * @return \DateTime
     */
    public function getCreateAt()
    {
        return $this->createdAt;
    }

    /**
     * Converts timetsamp in ISO_8601 format to DateTime object
     *
     * @param mixed $timestamp Timestamp
     *
     * @return \Box\Entity\DateTime|null
     */
    protected function _convertToDateTime($timestamp)
    {
        if ($timestamp instanceof \DateTime) {
            return $timestamp;
        } else if ($timestamp === null) {
            return null;
        }

        return \DateTime::createFromFormat(\DateTime::ISO8601, $timestamp);
    }
}
