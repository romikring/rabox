<?php
/**
 * Description of Token
 *
 * @author romik
 */
namespace Box\Auth;

use Box\Auth\Exception;
use Box\Transport\Curl;

/**
 *
 */
class Token implements Interfaces\Token
{
    const TOKEN_URI = 'https://www.box.com/api/oauth2/token';
    const REVOKE_URI = 'https://www.box.com/api/oauth2/revoke';

    /**
     * Refresh token is valid for 14 days from last request,
     * see box manual http://developers.box.com/oauth/
     */
    const REFRESH_TOKEN_LIFETIME =  1209600;

    /**
     * The grant type of this request. Will be authorization_code,refresh_token, or urn:box:oauth2:grant-type:provision
     * depending on which is accompanying this request
     *
     * @var string
     */
    protected $grantType;
    /**
     * An authorization code you retrieved in the first leg of OAuth 2
     *
     * @var string
     */
    protected $code;
    /**
     * A refresh token retrieved in the final leg of OAuth 2
     *
     * @var string
     */
    protected $refreshToken;
    /**
     * Application's client ID
     *
     * @var string
     */
    protected $clientId;
    /**
     * Application’s client_secret
     *
     * @var string
     */
    protected $clientSecret;
    /**
     * Required only if a redirect URI is not configured at box.com/developers/services
     *
     * @var type
     */
    protected $redirectUri;
    /**
     * Required only if using urn:box:oauth2:grant-type:provision grant
     *
     * @var string
     */
    protected $username;
    /**
     * Optional unique ID of this device. Used for applications that want to support device-pinning.
     *
     * @var string
     */
    protected $deviceId;
    /**
     * Optional human readable name for this device.
     *
     * @var string
     */
    protected $deviceName;
    /**
     * AccessToken
     *
     * @var string
     */
    protected $accessToken;
    /**
     * AccessToken create or refresh timestamp
     *
     * @var integer
     */
    protected $burnTime;
    /**
     * AccessToken life time
     *
     * @var integer
     */
    protected $expiresIn;
    /**
     *
     * @var array
     */
    protected $restrictedTo;
    /**
     * AccessToken type
     *
     * @var string
     */
    protected $tokenType;
    /**
     * @var Curl
     */
    private $transport;

    /**
     * The Constructor
     *
     * @param string $clientId Client ID from Box application options
     * @param string $secret  Client Secret from Box application options
     */
    public function __construct($clientId, $secret)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $secret;

        $this->transport = new Curl();
    }

    /**
     * Do accessToken validation and refresh when it need
     *
     * @return boolean
     */
    public function isValid()
    {
        if (!$this->accessToken || !$this->refreshToken) {
            false;
        }

        $now = time();

        if ($this->burnTime + $this->expiresIn > $now) {
            return true;
        }

        if ($now - $this->burnTime > $this->expiresIn && $this->burnTime + self::REFRESH_TOKEN_LIFETIME > $now) {
            try {
                return $this
                    ->refresh()
                    ->isValid();
            } catch(Exception $e) {
                return false;
            }
        }

        return false;
    }

    /**
     * Refresh current user's token
     *
     * @return Token
     */
    public function refresh()
    {
        $burnTime = time();

        $this->transport->setMethod(Curl::METHOD_POST);
        $this->transport->setUrl(self::TOKEN_URI);
        $this->transport
            ->addData('client_id', $this->getClientId())
            ->addData('client_secret', $this->getClientSecret());

        if (!empty($this->refreshToken)) {
            $this->transport
                ->addData('refresh_token', $this->getRefreshToken())
                ->addData('grant_type', 'refresh_token')
                ->addData('device_name', $this->getDeviceName())
                ->addData('device_id', $this->getDeviceId());
        } else {
            $this->transport
                ->addData('grant_type', 'authorization_code')
                ->addData('code', $this->getCode())
                ->addData('redirect_uri', $this->getRedirectUri());
        }
        $response = json_decode($this->transport->getResponse(), true);

        if ($this->transport->getLastStatusCode() != 200) {
            if (!$response || !isset($response['error_description'])) {
                $msg = 'Oops, something went wrong. Server returned wrong status code: '.$this->transport->getLastStatusCode();
            } else {
                $msg = $response['error_description'];
            }
            throw new Exception($msg);
        }

        $this->setBurnTime($burnTime);
        $this->_populate($response);

        return $this;
    }

    /**
     * Crearing current token. Log out the user if hi was logged in.
     *
     * @return \Box\Auth\Token
     */
    public function clear()
    {
        $propetries = array('code', 'refreshToken', 'accessToken', 'expireIn', 'username', 'deviceId', 'deviceName', 'burnTime');
        foreach ($propetries as $prop) {
            if (isset($this->{$prop})) {
                $this->{$prop} = null;
            }
        }

        return $this;
    }

    /**
     * Destroying Tokens
     *
     * @return Token
     */
    public function revoke()
    {
        $this->transport->setMethod(Curl::METHOD_POST);
        $this->transport->setUrl(self::REVOKE_URI);
        $this->transport
            ->addData('client_id', $this->getClientId())
            ->addData('client_secret', $this->getClientSecret())
            ->addData('token', $this->getRefreshToken());

        $this->transport->getResponse();
        $this->clear();

        return $this;
    }

    /**
     * Sets last successful request time
     *
     * @param integer $time Timestamp
     *
     * @return Token
     */
    public function setBurnTime($time)
    {
        $this->burnTime = (integer) $time;

        return $this;
    }

    /**
     * Returns last successful request time
     *
     * @return ineteger
     */
    public function getBurnTime()
    {
        return $this->burnTime;
    }

    /**
     * Sets access token
     *
     * @param string $token Access Token
     *
     * @return Token
     */
    public function setAccessToken($token)
    {
        $this->accessToken = $token;

        return $this;
    }

    /**
     * Returns access token
     *
     * @return string
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * Sets time when access token is valid
     *
     * @param integer $seconds Seconds
     *
     * @return Token
     */
    public function setExpiresIn($seconds)
    {
        $this->expiresIn = (integer) $seconds;

        return $this;
    }

    /**
     * Returns time when access token is valid
     *
     * @return string
     */
    public function getExpiresIn()
    {
        return $this->expiresIn;
    }

    /**
     *
     * @param array $restrict
     *
     * @return Token
     */
    public function setRestrictedTo($restrict)
    {
        $this->restrictedTo = $restrict;

        return $this;
    }

    /**
     *
     * @return array
     */
    public function getRestrictedTo()
    {
        return $this->restrictedTo;
    }

    /**
     * Sets token's type
     *
     * @param string $type
     *
     * @return Token
     */
    public function setTokenType($type)
    {
        $this->tokenType = $type;

        return $this;
    }

    /**
     * Returns token's type
     *
     * @return string
     */
    public function getTokenType()
    {
        return $this->tokenType;
    }

    /**
     * Sets grant_type
     *
     * @param string $type
     *
     * @throws Exception
     *
     * @return \Box\Auth\Token
     */
    public function setGrantType($type)
    {
        switch($type) {
            case 'authorization_code':
            case 'refresh_token':
            case 'urn:box:oauth2:grant-type:provision':
                $this->grantType = $type;
                break;
            default:
                throw new Exception('Unknown grant type: '.$type);
        }

        return $this;
    }

    /**
     * Retruns grant_type
     *
     * @return string
     */
    public function getGrantType()
    {
        return $this->grantType;
    }

    /**
     * Sets code retrived from auth first leg
     *
     * @param string $code
     *
     * @return Token
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Returns code retrived from auth first leg
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Sets refresh_token
     *
     * @param string $token Valid refresh_token
     *
     * @return Token
     */
    public function setRefreshToken($token)
    {
        $this->refreshToken = $token;

        return $this;
    }

    /**
     * Returns refresh_token
     *
     * @return Token
     */
    public function getRefreshToken()
    {
        return $this;
    }

    /**
     * Sets client_id
     *
     * @param string $clientId
     *
     * @return Token
     */
    public function setClientId($clientId)
    {
        $this->clientId = $clientId;

        return $this;
    }

    /**
     * Returns client_id
     *
     * @return string
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * Sets client_secret
     *
     * @param string $secret
     *
     * @return Token
     */
    public function setClientSecret($secret)
    {
        $this->clientSecret = $secret;

        return $this;
    }

    /**
     * Returns client_secret
     *
     * @return string
     */
    public function getClientSecret()
    {
        return $this->clientSecret;
    }

    /**
     * Sets device id (optional)
     *
     * @param string $deviceId
     *
     * @return Token
     */
    public function setDeviceId($deviceId)
    {
        $this->deviceId = $deviceId;

        return $this;
    }

    /**
     * Returns device id (optional)
     *
     * @return string
     */
    public function getDeviceId()
    {
        return $this->deviceId;
    }

    /**
     * Sets device name (optional)
     *
     * @param string $deviceName
     *
     * @return Token
     */
    public function setDeviceName($deviceName)
    {
        $this->deviceName = $deviceName;

        return $this;
    }

    /**
     * Returns device name (optional)
     *
     * @return string
     */
    public function getDeviceName()
    {
        return $this->deviceName;
    }

    /**
     * Sets redirect Uri after gets access token
     *
     * @param string $redirectUri
     *
     * @return Token
     */
    public function setRedirectUri($redirectUri)
    {
        $this->redirectUri = $redirectUri;

        return $this;
    }

    /**
     * Returns redirect uri
     *
     * @return string
     */
    public function getRedirectUri()
    {
        return $this->redirectUri;
    }

    /**
     * Sets username (optional)
     *
     * @param string $username
     *
     * @return Token
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Returns username (optional)
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Populates or updates Token instance with valid data
     *
     * @param array $data
     */
    private function _populate(array $data)
    {
        foreach ($data as $field => $value) {
            $method = 'set' . (str_replace('_', '', $field));
            if (!is_callable(array($this, $method), true)) {
                trigger_error(sprintf("Mehtod %s not found in class %s", $method, get_class()), E_USER_ERROR);
            }

            $this->{$method}($value);
        }
    }
}
