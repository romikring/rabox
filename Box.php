<?php
/**
 * Description of Token
 *
 * @author romik
 */
namespace Box;

use Box\Auth\Authorize;

/**
 *
 */
class Box
{
    /**
     * Application key
     *
     * @var string
     */
    protected $apiKey;

    /**
     *
     * @param type $apiKey
     */
    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function isAuthorized()
    {
        return $this->token->has();
    }
}
