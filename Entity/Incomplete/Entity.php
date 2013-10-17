<?php
/**
 * Description of Entity
 *
 * @author Roman Habrusionok <romikring@gmail.com>
 */
namespace Box\Entity\Incomplete;

use Box\Exception;

abstract class Entity
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
     * When this entity was last updated on the Box servers
     *
     * @var \DateTime
     */
    protected $modifiedAt;
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
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Sets when this file was last updated on the Box servers
     *
     * @param mixed $timestamp Timestamp|DateTime object
     *
     * @return \Box\Entity\Incomplete\File
     */
    public function setModifiedAt($timestamp)
    {
        $this->modifiedAt = $this->_convertToDateTime($timestamp);

        return $this;
    }

    /**
     * Returns when this file was last updated on the Box servers
     *
     * @return \DateTime
     */
    public function getModifiedAt()
    {
        return $this->modifiedAt;
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

        return \DateTime::createFromFormat(\DateTime::ATOM, $timestamp);
    }

    /**
     * Convert JSON string to target entity
     *
     * @param string $data JSON string
     *
     * @throws Box\Exception
     *
     * @return Entity
     *
     */
    static protected function _convertToTarget($data)
    {
        if ($data instanceof Entity) {
            return $data;

        } else if (is_string($data)) {
            $data = trim($data);

            if ($data{0} === '{') {
                // JSON string
                if (false === ($obj = json_decode($data, true))) {
                    throw new Exception(sprintf('Object "%s" couldn\'t be converted to Entity object', $data));
                }
                $data = $obj;
            }
        }
        if (!is_array($data)) {
                throw new Exception("Unknown object for convertation to User");
        }

        $entity = new static();

        foreach ($data as $field => $value) {
            $setter = 'set' . str_replace('_', '', ucfirst($field));
            if (method_exists($entity, $setter)) {
                $entity->$setter($value);
            } else if ($field === 'type') {
                continue;
            } else {
                throw new Exception(sprintf('Unknown method name "%s" in %s', $setter, get_class($entity)));
            }
        }

        return $entity;
    }
}
