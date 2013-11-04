<?php
/**
 * Description of Token
 *
 * @author romik
 */
namespace Box\Auth\Interfaces;

/**
 *
 */
interface Token
{
    /**
     * Returns there is user's access token or not
     */
    public function isValid();
}
