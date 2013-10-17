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
}
