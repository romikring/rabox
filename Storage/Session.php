<?php
/**
 * Description of Session
 *
 * @author romik
 */
namespace Box\Storage;

/**
 * Session wrapper implementation
 */
class Session
{
    const SESSION_NAMESPACE = '--BOX--';

    /**
     * Reference to session array
     *
     * @var array
     */
    private $storage;
    /**
     * Uniq storage label
     *
     * @var string
     */
    private $namespase;

    /**
     * The Constructor
     *
     * @param string $namespase
     *
     * @throws Exception
     */
    public function __construct($namespase)
    {
        if (session_status() !== PHP_SESSION_ACTIVE && !session_start()) {
            throw new Exception('Session start failed');
        }

        $this->namespase = $namespase;
        $this->storage =& $_SESSION[self::SESSION_NAMESPACE][$this->namespase];
    }

    /**
     * Data setter
     *
     * @param string $key  Data key
     * @param mixed $value Date
     *
     * @return Session
     */
    public function set($key, $value)
    {
        $this->storage[$key] = $value;

        return $this;
    }

    /**
     * Data getter
     *
     * @param string $key
     *
     * @return mixed
     */
    public function get($key)
    {
        return $this->storage[$key];
    }

    /**
     * Checks data exists or not
     *
     * @param string $key Key
     *
     * @return boolean
     */
    public function has($key)
    {
        return isset($this->storage[$key]);
    }

    /**
     * Delete some data by key
     *
     * @param string $key Key
     *
     * @return Session
     */
    public function delete($key)
    {
        unset($this->storage[$key]);

        return $this;
    }

    /**
     * Destroy all data for current namespase
     *
     * @return Session
     */
    public function destroy()
    {
        unset($_SESSION[self::SESSION_NAMESPACE][$this->namespase]);
        $_SESSION[self::SESSION_NAMESPACE][$this->namespase] = null;

        return $this;
    }

    /**
     * Resets all data under current namespace
     *
     * @return Session
     */
    public function reset()
    {
        $this->destroy();

        $_SESSION[self::SESSION_NAMESPACE][$this->namespase] = array();

        return $this;
    }
}
