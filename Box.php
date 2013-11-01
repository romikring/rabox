<?php
/**
 * Description of Token
 *
 * @author romik
 */
namespace Box;

use Box\Auth\Interfaces\Auth as AuthInterface;

/**
 * Box API entry point instance
 */
class Box
{
    /**
     * Auth instance
     *
     * @var Auth
     */
    protected $auth;
    /**
     * Options
     *
     * @var array
     */
    protected $options;

    /**
     * The constructor
     *
     * @param array $options Box options
     */
    public function __construct(array $options = null)
    {
        $this->options = (null === $options) ? array() : $options;
    }

    /**
     * Returns is user authorized or not
     *
     * @return boolean
     */
    public function isAuthorized()
    {
        return $this->getAuth()->isAuthenticated();
    }

    /**
     * Returns Auth instance
     *
     * @return AuthInterface
     */
    public function getAuth()
    {
        if (!isset($this->auth)) {
            $this->auth = new Auth($this->options);
        }

        return $this->auth;
    }

    public function setAuth(AuthInterface $auth)
    {
        $this->auth = $auth;

        return $this;
    }
}
