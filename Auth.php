<?php
/**
 * Description of Auth
 *
 * @author Roman Habrusionok <romikring@gmail.com>
 */
namespace Box;

use Box\Auth\Interfaces\Auth as AuthInterface;
use Box\Storage\Interfaces\Storage as StorageInterface;
use Box\Storage\Session;
use Box\Auth\Token;


/**
 *
 */
class Auth implements AuthInterface
{
    const URL_BASE = 'https://www.box.com/api/oauth2/authorize';
    const STORAGE_NAMESPASE = 'auth';

    /**
     * Storage
     *
     * @var StorageInterface
     */
    private $storage;
    /**
     * Token instance
     *
     * @var Token
     */
    private $token;
    /**
     * @var string
     */
    protected $apiKey;
    /**
     * @var string
     */
    protected $clientId;
    /**
     * @var string
     */
    protected $clientSecret;
    /**
     *
     * @var string
     */
    protected $redirectUri;

    /**
     * The constructor
     *
     * @param mixed $options Option values
     */
    public function __construct(array $options, StorageInterface $storage = null)
    {
        if (empty($storage)) {
            $storage = new Session(self::STORAGE_NAMESPASE);
        }
        $this->storage = $storage;

        foreach ($options as $name => $value) {
            $method = 'set'.(str_replace('_', '', $name));

            if (is_callable(array($this, $method), true)) {
                $this->$method($value);
            } else {
                trigger_error(sprintf("Method %s not found in %s. Option %s isn't setted", $method, get_class(), $name), E_USER_WARNING);
            }
        }
    }

    /**
     * API Key setter
     *
     * @param string $key API Key
     *
     * @return Box
     */
    public function setApiKey($key)
    {
        $this->apiKey = $key;

        return $this;
    }

    /**
     * Clien ID setter
     *
     * @param string $id Client ID
     *
     * @return Box
     */
    public function setClientId($id)
    {
        $this->clientId = $id;

        return $this;
    }

    /**
     * Client Secret setter
     *
     * @param string $secret Secret
     *
     * @return Box
     */
    public function setClientSecret($secret)
    {
        $this->clientSecret = $secret;

        return $this;
    }

    /**
     * Authenticated Url response to
     *
     * @param string $url
     *
     * @return Auth
     */
    public function setRedirectUri($url)
    {
        $url = trim($url);

        if (strpos($url, 'https://') === 0 || strpos($url, 'http://') === 0) {
            $this->redirectUri = $url;
        } else {
            if (empty($url)) {
                throw new Auth\Exception('Redirect Uri is required and cannot be empty');
            } else {
                throw new Auth\Exception('Redirect Uri invalid. It must starts from protocol: https or http');
            }
        }

        return $this;
    }

    /**
     * Returns uri for redirect
     *
     * @return string
     */
    public function generateAuthUrl()
    {
        return sprintf(
            '%s?response_type=code&client_id=%s&state=authenticated&redirect_uri=%s',
            self::URL_BASE,
            urlencode($this->clientId),
            urlencode($this->redirectUri)
        );
    }

    /**
     * Token setter
     *
     * @param Token $token Token instance
     *
     * @return Auth
     */
    public function setToken(Token $token)
    {
        $this->token = $token;
        $this->storage->set('token', $this->token);

        $this->token->refresh();

        return $this;
    }

    /**
     * @todo Refresh token
     *
     * @return boolean
     */
    public function isAuthenticated()
    {
        if (empty($this->token) && !$this->storage->has('token')) {
            return false;
        } elseif (empty($this->token) && $this->storage->has('token')) {
            $this->token = $this->storage->get('token');
        }
        $this->token->refresh();

        return $this->token->isValid();
    }

    protected function refresh()
    {
    }

    protected function revoke()
    {
    }
}
