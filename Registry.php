<?php
/**
 * Description of Entity
 *
 * @author Roman Habrusionok <romikring@gmail.com>
 */
namespace Box;

use Box\Storage\Entity as EntityStorage;

/**
 * Registry object
 */
class Registry
{
    /**
     * Registry object
     *
     * @var Registry
     */
    static private $_instance = null;

    /**
     * Storage object
     *
     * @var EntityStorage
     */
    protected $storage;

    /**
     * The Constructor
     *
     * This method is private, you cannot use it, use getInstance() method instead of
     */
    private function __construct()
    {
        $this->storage = new EntityStorage;
    }

    /**
     * __clone() Method is depricated because singleton
     *
     * @deprecated
     */
    public function __clone()
    {
        trigger_error('Object cannot be clonned', E_USER_ERROR);
    }

    /**
     * Registry entry point
     *
     * @return Registry
     */
    static public function getInstance()
    {
        if (self::$_instance === null) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    /**
     * Returns entity's storage
     *
     * @return EntityStorage
     */
    public function getStorage()
    {
        return $this->storage;
    }
}
