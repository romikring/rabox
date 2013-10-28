<?php
/**
 * Description of FileTest
 *
 * @author Roman Habrusionok <romikring@gmail.com>
 */
namespace Box\Tests;

use Box\Entity\File;

class FileTest extends \PHPUnit_Framework_TestCase
{
    protected $fixture = 'file.json';

    /**
     * File testing object
     *
     * @var File
     */
    protected $file;

    protected function setUp()
    {
        $filename = FIXTURES_PATH.$this->fixture;
        $json = file_get_contents($filename);

        $this->file = File::load($json);
    }

    public function testId()
    {
        $this->assertEquals($this->file->getId(), '5000948880');
        $this->assertInstanceof(
            'Box\\Entity\\File',
            $this->file->setId($this->file->getId() + 1)
        );
        $this->assertEquals($this->file->getId(), '5000948881');
    }

    /**
     * @covers Box\Entity\File::setCommentCount
     * @covers Box\Entity\File::getCommentCount
     */
    public function testSetCommentCount()
    {
        $this->assertInstanceOf(
            'Box\\Entity\\File',
            $this->file->setCommentCount("2")
        );

        $this->assertEquals(2, $this->file->getCommentCount());
        $this->assertInternalType('int', $this->file->getCommentCount());
        $this->file->setCommentCount(NULL);
        $this->assertInternalType('int', $this->file->getCommentCount());
        $this->assertEquals(0, $this->file->getCommentCount());
    }

    /**
     * @covers Box\Entity\File::setSha1
     * @covers Box\Entity\File::getSha1
     */
    public function testSetSha1()
    {
        $this->assertEquals('134b65991ed521fcfe4724b7d814ab8ded5185dc', $this->file->getSha1());

        $sha1 = sha1('134b65991ed521fcfe4724b7d814ab8ded5185dc');
        $this->assertInstanceOf(
            'Box\\Entity\\File',
            $this->file->setSha1($sha1)
        );
    }

    /**
     * @covers Box\Entity\File::setVersionNumber
     * @covers Box\Entity\File::getVersionNamber
     */
    public function testSetVersionNumber()
    {
        $version = "2";
        $this->assertInstanceOf(
            'Box\\Entity\\File',
            $this->file->setVersionNumber($version)
        );

        $this->assertEquals($version, $this->file->getVersionNamber());
    }

    /**
     * @covers Box\Entity\Incomplete\File::setParent
     * @covers Box\Entity\Incomplete\File::getParent
     */
    public function testSetParent()
    {
        $this->assertInstanceOf(
            'Box\\Entity\\Folder',
            $this->file->getParent()
        );

        $this->assertInstanceOf(
            'Box\\Entity\\File',
            $this->file->setParent($this->file->getParent())
        );
    }

    /**
     * @expectedException Box\Exception
     */
    public function testSetParentException1()
    {
        $this->file->setParent(NULL);
    }

    /**
     * @expectedException Box\Exception
     */
    public function testSetParentException2()
    {
        $this->file->setParent('{invalid}');
    }

    /**
     * @covers Box\Entity\Incomplete\File::setSequenceId
     * @covers Box\Entity\Incomplete\File::getSequenceId
     */
    public function testSetSequenceId()
    {
        $this->assertEquals("3", $this->file->getSequenceId());
        $this->assertInstanceOf(
            'Box\\Entity\\File',
            $this->file->setSequenceId("4")
        );
    }


    /**
     * @covers Box\Entity\Incomplete\File::setContentCreatedAt
     * @covers Box\Entity\Incomplete\File::getContentCreatedAt
     */
    public function testSetContentCreatedAt()
    {
        $date = $this->file->getContentCreatedAt();
        $this->assertInstanceOf('\DateTime', $date);

        $this->assertEquals($date->format(\DateTime::ATOM), "2013-02-04T16:57:52-08:00");

        $this->assertInstanceOf('Box\Entity\File', $this->file->setContentCreatedAt(NULL));
        $this->assertEquals(NULL, $this->file->getContentCreatedAt());
    }

    /**
     * @covers Box\Entity\Incomplete\File::setContentModifiedAt
     * @covers Box\Entity\Incomplete\File::getContentModifiedAt
     */
    public function testSetContentModifiedAt()
    {
        $date = $this->file->getContentModifiedAt();
        $this->assertInstanceOf('\DateTime', $date);

        $this->assertEquals($date->format(\DateTime::ATOM), "2013-02-04T16:57:52-08:00");

        $this->assertInstanceOf('Box\Entity\File', $this->file->setContentModifiedAt(NULL));
        $this->assertEquals(NULL, $this->file->getContentModifiedAt());
    }

    /**
     * @covers Box\Entity\Incomplete\File::setCreatedBy
     * @covers Box\Entity\Incomplete\File::getCreatedBy
     */
    public function testSetCreatedBy()
    {
        $user = $this->file->getCreatedBy();

        $this->assertInstanceOf('Box\Entity\User', $user);
        $this->assertInstanceOf('Box\Entity\File', $this->file->setCreatedBy($user));
    }

    /**
     * @covers Box\Entity\Incomplete\File::setDescription
     * @covers Box\Entity\Incomplete\File::getDescription
     */
    public function testSetDescription()
    {
        $this->assertEquals("a picture of tigers", $this->file->getDescription());
        $this->assertInstanceOf(
            'Box\Entity\File',
            $this->file->setDescription('test description')
        );
    }

    /**
     * @covers Box\Entity\Incomplete\File::setETag
     * @covers Box\Entity\Incomplete\File::getETag
     */
    public function testSetETag()
    {
        $this->assertEquals('3', $this->file->getETag());
        $this->assertInstanceOf(
            'Box\Entity\File',
            $this->file->setETag(4)
        );
    }

    /**
     * @covers Box\Entity\Incomplete\File::setModifiedBy
     * @covers Box\Entity\Incomplete\File::getModifiedBy
     */
    public function testSetModifiedBy()
    {
        $user = $this->file->getModifiedBy();

        $this->assertInstanceOf('Box\Entity\User', $user);
        $this->assertInstanceOf('Box\Entity\File', $this->file->setModifiedBy($user));
    }

    /**
     * @covers Box\Entity\Incomplete\File::setName
     * @covers Box\Entity\Incomplete\File::getName
     */
    public function testSetName()
    {
        $this->assertEquals("tigers.jpeg", $this->file->getName());
        $this->assertInstanceOf('\Box\Entity\File', $this->file->setName('test.jpg'));
    }

    /**
     * @covers Box\Entity\Incomplete\File::setOwnedBy
     * @covers Box\Entity\Incomplete\File::getOwnedBy
     */
    public function testSetOwnedBy()
    {
        $user = $this->file->getOwnedBy();
        $this->assertInstanceOf('Box\Entity\User', $user);
        $this->assertInstanceOf('Box\Entity\File', $this->file->setOwnedBy($user));
    }

    /**
     * @covers Box\Entity\Incomplete\File::setPathCollection
     * @covers Box\Entity\Incomplete\File::getPathCollection
     */
    public function testSetPathCollection()
    {
        $collection = $this->file->getPathCollection();
        $this->assertInstanceOf('Box\Container\Collection', $collection);
        $this->assertInstanceOf('Box\Entity\File', $this->file->setPathCollection($collection));
    }

    /**
     * @covers Box\Entity\Incomplete\File::setPurgedAt
     * @covers Box\Entity\Incomplete\File::getPurgedAt
     */
    public function testSetPurgedAt()
    {
        $this->assertEquals(NULL, $this->file->getPurgedAt());
        $this->assertInstanceOf('Box\Entity\File', $this->file->setPurgedAt("2013-02-04T16:57:52-08:00"));

        $date = $this->file->getPurgedAt();
        $this->assertInstanceOf('\DateTime', $date);
        $this->assertEquals($date->format(\DateTime::ATOM), "2013-02-04T16:57:52-08:00");
    }

    /**
     * @covers Box\Entity\Incomplete\File::setSharedLink
     * @covers Box\Entity\Incomplete\File::getSharedLink
     */
    public function testSetSharedLink()
    {
        $sharedLink = $this->file->getSharedLink();
        $this->assertInstanceOf('Box\Entity\SharedLink', $sharedLink);
        $this->assertInstanceOf('Box\Entity\File', $this->file->setSharedLink($sharedLink));
    }

    /**
     * @covers Box\Entity\Incomplete\File::setSize
     * @covers Box\Entity\Incomplete\File::getSize
     */
    public function testSetSize()
    {
        $this->assertEquals($this->file->getSize(), 629644);
        $this->assertInstanceOf('Box\Entity\File', $this->file->setSize(45));
    }

    /**
     * @covers Box\Entity\Incomplete\File::setTrashedAt
     * @covers Box\Entity\Incomplete\File::getTrashedAt
     */
    public function testSetTrashedAt()
    {
        $this->assertNull($this->file->getTrashedAt());
        $this->assertInstanceOf('Box\Entity\File', $this->file->setTrashedAt('2012-12-12T10:55:30-08:00'));
        $this->assertEquals($this->file->getTrashedAt()->format(\DateTime::ATOM), '2012-12-12T10:55:30-08:00');
    }

    /**
     * @covers Box\Entity\Incomplete\File::setItemStatus
     * @covers Box\Entity\Incomplete\File::getItemStatus
     */
    public function testSetItemStatus()
    {
        $this->assertEquals($this->file->getItemStatus(), 'active');
        $this->assertInstanceOf('Box\Entity\File', $this->file->setItemStatus('inactive'));
    }

    /**
     * @expectedException Box\Exception
     */
    public function testSetItemStatusException1()
    {
        $this->file->setItemStatus(array('active'));
    }

    /**
     * @expectedException Box\Exception
     */
    public function testSetItemStatusException2()
    {
        $this->file->setItemStatus('aactive');
    }

    /**
     * @covers Box\Entity\Incomplete\File::isTrashed
     */
    public function testIsTrashed()
    {
        $this->assertFalse($this->file->isTrashed());
        $this->file->setTrashedAt(new \DateTime);
        $this->assertTrue($this->file->isTrashed());
    }

    /**
     * @covers Box\Entity\Incomplete\File::isPurged
     */
    public function testIsPurged()
    {
        $this->assertFalse($this->file->isPurged());
        $this->file->setPurgedAt(new \DateTime);
        $this->assertTrue($this->file->isPurged());
    }
}
