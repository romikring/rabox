<?php
/**
 * Description of Folder
 *
 * @author Roman Habrusenok <romikring@gmail.com>
 */
namespace Box\Entity;

use Box\Entity\Incomplete\File as IncompleteFile;
use Box\Storage\UploadEmail;
use Box\Container\Collection;

/**
 * Folder Entity class
 */
class Folder extends IncompleteFile
{
    const ENTITY_TYPE = 'folder';

    /**
     * The upload email address for this folder. Null if not set
     *
     * @var UploadEmail
     */
    protected $folderUploadEmail;
    /**
     * A collection of files and folders contained in current folder
     *
     * @var Collection
     */
    protected $itemCollection;
    /**
     * Whether this folder will be synced by the Box sync clients or not.
     *
     * @var string
     */
    protected $syncState;
    /**
     * Whether this folder has any collaborators
     *
     * @var boolean
     */
    protected $hasCollaborations;

    /**
     * Sets upload email address for this folder. Null if not set
     *
     * @param mixed $email UploadEmail object|JSON representation
     *
     * @return \Box\Entity\Folder
     */
    public function setFolderUploadEmail($email)
    {
        $this->folderUploadEmail = UploadEmail::convertToUploadEmail($email);

        return $this;
    }

    /**
     * Returns UploadEmail object if it was setted
     *
     * @return UploadEmail|NULL
     */
    public function getFolderUploadEmail()
    {
        return $this->folderUploadEmail;
    }

    /**
     * Sets collection of items in folder
     *
     * @param mixed $collection Collection object|JSON representation
     *
     * @return \Box\Entity\Folder
     */
    public function setItemCollection($collection)
    {
        $this->itemCollection = Collection::convertToCollection($collection);

        return $this;
    }

    /**
     * Returns items collection
     *
     * @return Collection
     */
    public function getItemCollection()
    {
        return $this->itemCollection;
    }

    /**
     * Sets whether this folder will be synced by the Box sync clients or not
     *
     * @param string $state
     *
     * @return \Box\Entity\Folder
     */
    public function setSyncState($state)
    {
        $this->syncState = $state;

        return $this;
    }

    /**
     * Returns whether this folder will be synced by the Box sync clients or not
     *
     * @return string
     */
    public function getSyncState()
    {
        return $this->syncState;
    }

    /**
     * Sets whether this folder has any collaborators
     *
     * @param boolean $collaborations
     *
     * @return \Box\Entity\Folder
     */
    public function setCollaborations($collaborations)
    {
        $this->hasCollaborations = (boolean) $collaborations;

        return $this;
    }

    /**
     * Returns whether this folder has any collaborators
     *
     * @return boolean
     */
    public function hasCollaborations()
    {
        return $this->hasCollaborations;
    }
}
