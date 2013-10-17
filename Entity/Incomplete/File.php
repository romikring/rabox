<?php
/**
 * Description of File
 *
 * @author Roman Habrusionok <romikring@gmail.com>
 */
namespace Box\Entity\Incomplete;

use Box\Entity\User;
use Box\Entity\Folder;
use Box\Container\Collection;
use Box\Entity\SharedLink;
use Box\Exception;

abstract class File extends Entity
{
    /**
     * A unique ID for use with the /events endpoint
     *
     * @var string
     */
    protected $sequenceId;
    /**
     * A unique ID for use with the /events endpoint
     *
     * @var string
     */
    protected $etag;
    /**
     * The name of this file
     *
     * @var string
     */
    protected $name;
    /**
     * The description of this file
     *
     * @var string
     */
    protected $description;
    /**
     * Size of this file in bytes
     *
     * @var integer
     */
    protected $size;
    /**
     * The user who first created file
     *
     * @var User
     */
    protected $createdBy;
    /**
     * The user who last updated this file
     *
     * @var User
     */
    protected $modifiedBy;
    /**
     * The path of folders to this item, starting at the root
     *
     * @var Collection
     */
    protected $pathCollection;
    /**
     * When this file was last moved to the trash
     *
     * @var \DateTime
     */
    protected $trashedAt;
    /**
     * When this file will be permanently deleted
     *
     * @var \DateTime
     */
    protected $purgedAt;
    /**
     * When the content of this file was created
     *
     * @var \DateTime
     */
    protected $contentCreatedAt;
    /**
     * When the content of this file was last modified
     *
     * @var \DateTime
     */
    protected $contentModifiedAt;
    /**
     * The user who owns this file
     *
     * @var User
     */
    protected $ownedBy;
    /**
     * The shared link object for this file
     *
     * @var SharedLink
     */
    protected $sharedLink;
    /**
     * Whether this item is deleted or not
     *
     * @var string
     */
    protected $itemStatus;
    /**
     * Parent folder
     *
     * @var Folder
     */
    protected $parent;

    /**
     * Sets parent Folder
     *
     * @param mixed $folder Folder object or JSON object represantation
     *
     * @return \Box\Entity\Incomplete\File
     */
    public function setParent($folder)
    {
        $this->parent = Folder::_convertToTarget($folder);

        return $this;
    }

    /**
     * Returns parent Folder object
     *
     * @return Folder
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Sets unique ID for use with the /events endpoint
     *
     * @param string $sequenceId Unique ID
     *
     * @return \Box\Entity\File
     */
    public function setSequenceId($sequenceId)
    {
        $this->sequenceId = $sequenceId;

        return $this;
    }

    /**
     * Returns unique ID for use with the /events endpoint
     *
     * @return string
     */
    public function getSequenceId()
    {
        return $this->sequenceId;
    }

    /**
     * Sets when the content of this file was created
     *
     * @param mixed $timestamp
     *
     * @return \Box\Entity\File
     */
    public function setContentCreatedAt($timestamp)
    {
        $this->contentCreatedAt = $this->_convertToDateTime($timestamp);

        return $this;
    }

    /**
     * Returns when the content of this file was created
     *
     * @return \DateTime
     */
    public function getContentCreatedAt()
    {
        return $this->contentCreatedAt;
    }

    /**
     * Sets when the content of this file was last modified
     *
     * @param mixed $timestamp
     *
     * @return \Box\Entity\File
     */
    public function setContentModifiedAt($timestamp)
    {
        $this->contentModifiedAt = $this->_convertToDateTime($timestamp);

        return $this;
    }

    /**
     * Returns when the content of this file was last modified
     *
     * @return \DateTime
     */
    public function getContentModifiedAt()
    {
        return $this->contentModifiedAt;
    }

    /**
     * Sets user who first created file
     *
     * @param mixed $user
     *
     * @return \Box\Entity\File
     */
    public function setCreatedBy($user)
    {
        $this->createdBy = User::convertToUser($user);

        return $this;
    }

    /**
     * Returns user who first created file
     *
     * @return User
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Sets description of this file
     *
     * @param string $description
     *
     * @return \Box\Entity\Incomplete\File
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Returns description of this file
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets an unique ID for use with the /events endpoint
     *
     * @param string $etag
     *
     * @return \Box\Entity\Incomplete\File
     */
    public function setETag($etag)
    {
        $this->etag = $etag;

        return $this;
    }

    /**
     * Returns an unique ID for use with the /events endpoint
     *
     * @return string
     */
    public function getETag()
    {
        return $this->etag;
    }

    /**
     * Sets The user who last updated this file
     *
     * @param mixed $user User object|JSON string
     *
     * @return \Box\Entity\Incomplete\File
     */
    public function setModifiedBy($user)
    {
        $this->modifiedBy = User::convertToUser($user);

        return $this;
    }

    /**
     * Returns The user who last updated this file
     *
     * @return User
     */
    public function getModifiedBy()
    {
        return $this->modifiedBy;
    }

    /**
     * Sets name of this file
     *
     * @param string $name Name
     *
     * @return \Box\Entity\Incomplete\File
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Returns name of this file
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets user who owns this file
     *
     * @param mixed $user User object|JSON string
     *
     * @return \Box\Entity\Incomplete\File
     */
    public function setOwnedBy($user)
    {
        $this->ownedBy = User::convertToUser($user);

        return $this;
    }

    /**
     * Returns user who owns this file
     *
     * @return User
     */
    public function getOwnedBy()
    {
        return $this->ownedBy;
    }

    /**
     * Sets path of folders to this item, starting at the root
     *
     * @param mixed $path
     *
     * @return \Box\Entity\Incomplete\File
     */
    public function setPathCollection($path)
    {
        $this->pathCollection = Collection::convertToCollection($path);

        return $this;
    }

    /**
     * Returns path of folders to this item, starting at the root
     *
     * @return Collection
     */
    public function getPathCollection()
    {
        return $this->pathCollection;
    }

    /**
     * Sets when this file will be permanently deleted
     *
     * @param mixed $timestamp
     *
     * @return \Box\Entity\Incomplete\File
     */
    public function setPurgedAt($timestamp)
    {
        $this->purgedAt = $this->_convertToDateTime($timestamp);

        return $this;
    }

    /**
     * Retruns when this file will be permanently deleted
     *
     * @return \DateTime
     */
    public function getPurgedAt()
    {
        return $this->purgedAt;
    }

    /**
     * Sets  shared link object for this file
     *
     * @param mixed $sharedLink
     *
     * @return \Box\Entity\Incomplete\File
     */
    public function setSharedLink($sharedLink)
    {
        $this->sharedLink = SharedLink::convertToSharedLink($sharedLink);

        return $this;
    }

    /**
     * Returns SharedLink object
     *
     * @return SharedLink
     */
    public function getSharedLink()
    {
        return $this->sharedLink;
    }

    /**
     * Sets size of file in bytes
     *
     * @param integer $size
     *
     * @return \Box\Entity\Incomplete\File
     */
    public function setSize($size)
    {
        $this->size = (integer) $size;

        return $this;
    }

    /**
     * Returns size of file in bytes
     *
     * @return integer
     */
    public function getSize()
    {
        return $this->size ?: -1;
    }

    /**
     * Sets when this file was last moved to the trash
     *
     * @param mixed $timestamp
     *
     * @return \Box\Entity\Incomplete\File
     */
    public function setTrashedAt($timestamp)
    {
        $this->trashedAt = $this->_convertToDateTime($timestamp);

        return $this;
    }

    /**
     * Returns when this file was last moved to the trash
     *
     * @return \DateTime
     */
    public function getTrashedAt()
    {
        return $this->trashedAt;
    }

    /**
     * Whether this item is deleted or not
     *
     * @param string $status Status
     *
     * @return \Box\Entity\File
     */
    public function setItemStatus($status)
    {
        if (!is_string($status)) {
            throw new Exception('Item status must be string');
        }

        switch (trim(strtolower($status))) {
            case 'active':
            case 'inactive':
                $this->itemStatus = $status;
                break;
            default:
                throw new Exception('Item status have to be "active" or "inactive"');
        }

        return $this;
    }

    /**
     * Whether this file is trashed or not
     *
     * @return boolean
     */
    public function isTrashed()
    {
        return $this->trashedAt !== null;
    }

    /**
     * Whether this file is deleted permanently or not
     *
     * @return boolean
     */
    public function isPurged()
    {
        return $this->purgedAt !== null;
    }

    /**
     * Whether this item is deleted or not
     *
     * @return string
     */
    public function getItemStatus()
    {
        return $this->itemStatus;
    }

    static public function load($data)
    {
        return static::_convertToTarget($data);
    }
}
