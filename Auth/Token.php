<?php
/**
 * Description of Token
 *
 * @author romik
 */
namespace Box\Auth;

use Box\Auth\Exception;

/**
 *
 */
class Token implements Interfaces\Token
{
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

    public function has()
    {
    }

    public function refresh()
    {
    }

    /**
     * Sets grant type
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
     *
     * @return string
     */
    public function getGrantType()
    {
        return $this->grantType;
    }

    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function setRefreshToken($token)
    {
        $this->refreshToken = $token;

        return $this;
    }

    public function getRefreshToken()
    {
        return $this;
    }

    public function setClientId($clientId)
    {
        $this->clientId = $clientId;

        return $this;
    }

    public function getClientId()
    {
        return $this->clientId;
    }

    public function setClientSecret($secret)
    {
        $this->clientSecret = $secret;

        return $this;
    }

    public function getClientSecret()
    {
        return $this->clientSecret;
    }

    public function setDeviceId($deviceId)
    {
        $this->deviceId = $deviceId;
    }

    public function getDeviceId()
    {
        return $this->deviceId;
    }

    public function setDeviceName($deviceName)
    {
        $this->deviceName = $deviceName;

        return $this;
    }

    public function getDeviceName()
    {
        return $this->deviceName;
    }

    public function setRedirectUri($redirectUri)
    {
        $this->redirectUri = $redirectUri;

        return $this->redirectUri;
    }

    public function getRedirectUri()
    {
        return $this->redirectUri;
    }

    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    public function getUsername()
    {
        return $this->username;
    }
}
