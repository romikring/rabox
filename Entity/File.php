<?php
/**
 * Description of File
 *
 * @author romik
 */
namespace Box\Entity;

use Box\Entity\Incomplete\File as IncompleteFile;

/**
 * File Entity class
 */
class File extends IncompleteFile
{
    /**
     * Entity's type
     */
    const ENTITY_TYPE = 'file';

    /**
     * Entity's URI part
     */
    const ENTITY_URI = 'files/';

    /**
     * The sha1 hash of this file
     *
     * @var string
     */
    protected $sha1;
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
     * Sets sha1 hash of this file
     *
     * @param string $sha1 SHA1 hash
     *
     * @return \Box\Entity\File
     */
    public function setSha1($sha1)
    {
        $this->sha1 = $sha1;

        return $this;
    }

    /**
     * Returns sha1 hash of this file
     *
     * @return string
     */
    public function getSha1()
    {
        return $this->sha1;
    }

    /**
     * Sets version of the file
     *
     * @param string $version
     *
     * @return \Box\Entity\File
     */
    public function setVersionNumber($version)
    {
        $this->versionNumber = $version;

        return $this;
    }

    /**
     * Returns version of the file
     *
     * @return string
     */
    public function getVersionNamber()
    {
        return $this->versionNumber;
    }
}
