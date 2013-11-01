<?php
/**
 *
 * @author Roman Habrusionok <romikring@gmail.com>
 */
namespace Box\Auth\Interfaces;

/**
 * Auth interface
 */
interface Auth
{
    public function isAuthenticated();
    public function generateAuthUrl();
}
