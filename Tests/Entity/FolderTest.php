<?php
/**
 * Description of FolderTest
 *
 * @author Roman Habrusionok <romikring@gmail.com>
 */
namespace Box\Tests\Entity;

use Box\Entity\Folder;

class FolderTest extends \PHPUnit_Framework_TestCase
{
    protected $fixture = 'folder.json';

    /**
     * Testing object
     *
     * @var Folder
     */
    protected $folder;

    protected function setUp()
    {
        $filename = FIXTURES_PATH.$this->fixture;
        $json = file_get_contents($filename);

        $this->folder = Folder::load($json);
    }

    /**
     * @covers Box\Entity\Folder::setFolderUploadEmail
     * @covers Box\Entity\Folder::getFolderUploadEmail
     */
    public function testSetFolderUploadEmail()
    {
    }

    /**
     * @covers Box\Entity\Folder::setItemCollection
     * @covers Box\Entity\Folder::getItemCollection
     */
    public function testSetItemCollection()
    {
    }

    /**
     * @covers Box\Entity\Folder::setSyncState
     * @covers Box\Entity\Folder::getSyncState
     */
    public function testSetSyncState()
    {
    }

    /**
     * @covers Box\Entity\Folder::setCollaborations
     * @covers Box\Entity\Folder::hasCollaborations
     */
    public function testSetCollaborations()
    {
    }
}
