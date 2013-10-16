<?php
/**
 * Description of File
 *
 * @author romik
 */
namespace Box\Entity;

use Box\Entity\Mini\User;
use Box\Entity\Mini\Folder;
use Box\Container\Collection;

/**
 *
 */
class File extends AbstractEntity
{
    const ENTITY_TYPE = 'file';

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
     * The sha1 hash of this file
     *
     * @var string
     */
    protected $sha1;
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
     * The path of folders to this item, starting at the root
     *
     * @var array
     */
    protected $pathCollection;
    /**
     * When this file was last updated on the Box servers
     *
     * @var \DateTime
     */
    protected $modifiedAt;
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
     * The folder this file is contained in
     *
     * @var Folder
     */
    protected $folder;
    /**
     * Whether this item is deleted or not
     *
     * @var string
     */
    protected $status;
    /**
     * The version of the file
     *
     * @var string
     */
    protected $versionNumber;
    /**
     * The number of comments on a file
     *
     * @var string
     */
    protected $commentCount;

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
     * Sets number of comments on a file
     *
     * @param integer $count Comments count
     *
     * @return \Box\Entity\File
     */
    public function setCommentCount($count)
    {
        $this->commentCount = (integer) $count;

        return $this;
    }

    /**
     * Returns number of comments on a file
     *
     * @return integer
     */
    public function getCommentCount()
    {
        return (integer) $this->commentCount;
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
    public function getContentCreateAt()
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
     * Sets
     * @param type $user
     * @return \Box\Entity\File
     */
    public function setCreatedBy($user)
    {
        $this->createdBy = User::convertToMiniUser($user);

        return $this;
    }

    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setETag($etag)
    {
        $this->etag = $etag;

        return $this;
    }

    public function getETag()
    {
        return $this->etag;
    }

    public function setFolder($folder)
    {
        $this->folder = Folder::convertToMiniFolder($folder);

        return $this;
    }

    public function getFolder()
    {
        return $this->folder;
    }

    public function setModifiedAt($timestamp)
    {
        $this->modifiedAt = $this->_convertToDateTime($timestamp);

        return $this;
    }

    public function getModifiedAt()
    {
        return $this->modifiedAt;
    }

    public function setModifiedBy($user)
    {
        $this->modifiedBy = User::convertToMiniUser($user);

        return $this;
    }

    public function getModifiedBy()
    {
        return $this->modifiedBy;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setOwnedBy($user)
    {
        $this->ownedBy = User::convertToMiniUser($user);

        return $this;
    }

    public function getOwnedBy()
    {
        return $this->ownedBy;
    }

    public function setPathCollection($path)
    {
        $this->pathCollection = Collection::convertToCollection($path);

        return $this;
    }

    public function getPathCollection()
    {
        return $this->pathCollection;
    }

    public function setPurgedAt($timestamp)
    {
        $this->purgedAt = $this->_convertToDateTime($timestamp);

        return $this;
    }

    public function getPurgedAt()
    {
        return $this->purgedAt;
    }

    public function setSha1($sha1)
    {
        $this->sha1 = $sha1;

        return $this;
    }

    public function getSha1()
    {
        return $this->sha1;
    }

    public function setSharedLink($sharedLink)
    {
        $this->sharedLink = SharedLink::convertToSharedLink($sharedLink);

        return $this;
    }

    public function getSharedLink()
    {
        return $this->sharedLink;
    }

    public function setSize($size)
    {
        $this->size = (integer) $size;

        return $this;
    }

    public function getSize()
    {
        return $this->size ?: -1;
    }

    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setTrashedAt($timestamp)
    {
        $this->trashedAt = $this->_convertToDateTime($timestamp);

        return $this;
    }

    public function getTrashedAt()
    {
        return $this->trashedAt;
    }

    public function setVersionNumber($version)
    {
        $this->versionNumber = $version;

        return $this;
    }

    public function getVersionNamber()
    {
        return $this->versionNumber;
    }
}
