<?php
/**
 * Description of User
 *
 * @author Roman Habrusionok <romikring@gmail.com>
 */
namespace Box\Entity;

use Box\Container\Collection;
use Box\Entity\Incomplete\Entity;

/**
 * User class
 */
class User extends Entity
{
    const ENTITY_TYPE = 'user';

    /**
     * The name of this user
     *
     * @var string
     */
    protected $name;
    /**
     * The email address this user uses to login
     *
     * @var string
     */
    protected $login;
    /**
     * This user's enterprise role. Can be admin, coadmin, or user
     *
     * @var string
     */
    protected $role;
    /**
     * The language of this user
     *
     * @link http://en.wikipedia.org/wiki/ISO_639-1 ISO 639-1 Language Code
     *
     * @var string
     */
    protected $language;
    /**
     * The user's total available space amount in bytes
     *
     * @var integer
     */
    protected $spaceAmount;
    /**
     * The amount of space in use by the user
     *
     * @var integer
     */
    protected $spaceUsed;
    /**
     * The maximum individual file size in bytes this user can have
     *
     * @var integer
     */
    protected $maxUploadSize;
    /**
     * An array of key/value pairs set by the user's admin
     *
     * @var array
     */
    protected $trackingCodes;
    /**
     * Whether this user can see other enterprise users in its contact list
     *
     * @var boolean
     */
    protected $canSeeManagedUsers;
    /**
     * Whether or not this user can use Box Sync
     *
     * @var boolean
     */
    protected $isSyncEnabled;
    /**
     * Can be active or inactive
     *
     * @var string
     */
    protected $status;
    /**
     * The user's job title
     *
     * @var string
     */
    protected $jobTitle;
    /**
     * The user's phone number
     *
     * @var string
     */
    protected $phone;
    /**
     * The user's address
     *
     * @var string
     */
    protected $address;
    /**
     * URL of this user's avatar image
     *
     * @var string
     */
    protected $avatarUrl;
    /**
     * Whether to exempt this user from Enterprise device limits
     *
     * @var boolean
     */
    protected $isExemptFromDeviceLimits;
    /**
     * Whether or not this user must use two-factor authentication
     *
     * @var boolean
     */
    protected $isExemptFromLoginVerification;
    /**
     * The representation of this user's enterprise, including the ID of its enterprise
     *
     * @var Enterprise
     */
    protected $enterprise;

    /**
     * Tries to convert some data to User object
     *
     * @param mixed $user User object or JSON object representation
     *
     * @return User
     */
    static public function convertToUser($user)
    {
        return static::_convertToTarget($user);
    }

    /**
     * Sets name of this user
     *
     * @param string $name
     *
     * @return \Box\Entity\User
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Returns name of this user
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets email address this user uses to login
     *
     * @param string $login User's email
     *
     * @return \Box\Entity\User
     */
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Returns user's email
     *
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Sets user's address
     *
     * @param string $address
     *
     * @return \Box\Entity\User
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Returns user's address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Sets URL of this user's avatar image
     *
     * @param string $url URL
     *
     * @return \Box\Entity\User
     */
    public function setAvatarUrl($url)
    {
        $this->avatarUrl = $url;

        return $this;
    }

    /**
     * Returns URL of this user's avatar image
     *
     * @return string
     */
    public function getAvatarUrl()
    {
        return $this->avatarUrl;
    }

    /**
     * Whether this user can see other enterprise users in its contact list
     *
     * @param boolean $can Marker
     *
     * @return \Box\Entity\User
     */
    public function markAsCanSeeManagedUsers($can = true)
    {
        $this->canSeeManagedUsers = (boolean) $can;

        return $this;
    }

    /**
     * Whether this user can see other enterprise users in its contact list
     *
     * @return boolean
     */
    public function canSeeManagedUsers()
    {
        return (boolean) $this->canSeeManagedUsers;
    }

    /**
     * Sets representation of this user's enterprise, including the ID of its enterprise
     *
     * @param mixed $enterprise User representation
     *
     * @return \Box\Entity\User
     */
    public function setEnterprise($enterprise)
    {
        $this->enterprise = Enterprise::_convertToTarget($enterprise);

        return $this;
    }

    /**
     * Enterprise representation
     *
     * @return Enterprise
     */
    public function getEnterprise()
    {
        return $this->enterprise;
    }

    /**
     * Whether to exempt this user from Enterprise device limits
     *
     * @param boolean $limit Limit
     *
     * @return \Box\Entity\User
     */
    public function markExemptFromDeviceLimits($limit)
    {
        $this->isExemptFromDeviceLimits = (boolean) $limit;

        return $this;
    }

    /**
     * Whether to exempt this user from Enterprise device limits
     *
     * @return boolean
     */
    public function isExemptFromDeviceLimits()
    {
        return (boolean) $this->isExemptFromDeviceLimits;
    }

    /**
     *
     * @param boolean $verification
     *
     * @return \Box\Entity\User
     */
    public function setExemptFromLoginVerification($verification)
    {
        $this->isExemptFromLoginVerification = $verification;

        return $this;
    }

    /**
     * Whether or not this user must use two-factor authentication
     *
     * @return boolean
     */
    public function isExemptFromLoginVerification()
    {
        return $this->isExemptFromLoginVerification;
    }

    /**
     * Whether or not this user can use Box Sync
     *
     * @param boolean $enabled
     *
     * @return \Box\Entity\User
     */
    public function setSyncEnabled($enabled)
    {
        $this->isSyncEnabled = (boolean) $enabled;

        return $this;
    }

    /**
     * Whether or not this user can use Box Sync
     *
     * @return boolean
     */
    public function isSyncEnabled()
    {
        return $this->isSyncEnabled;
    }

    /**
     * Sets user's job title
     *
     * @param string $title Job title
     *
     * @return \Box\Entity\User
     */
    public function setJobTitle($title)
    {
        $this->jobTitle = $title;

        return $this;
    }

    /**
     * Returns user's job title
     *
     * @return string
     */
    public function getJobTitle()
    {
        return $this->jobTitle;
    }

    /**
     * Sets language of this user
     *
     * @param string $lang Language
     *
     * @return \Box\Entity\User
     */
    public function setLanguage($lang)
    {
        $this->language = $lang;

        return $this;
    }

    /**
     * Returns language of this user
     *
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Sets maximum individual file size in bytes this user can have
     *
     * @param integer $bytes Amount of bytes
     *
     * @return \Box\Entity\User
     */
    public function setMaxUploadSize($bytes)
    {
        $this->maxUploadSize = $bytes;

        return $this;
    }

    /**
     * Returns maximum individual file size in bytes this user can have
     *
     * @return integer
     */
    public function getMaxUploadSize()
    {
        return $this->maxUploadSize;
    }

    /**
     * Sets user's phone number
     *
     * @param string $phone Phone number
     *
     * @return \Box\Entity\User
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Returns the user's phone number
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Sets user's enterprise role. Can be admin, coadmin, or user
     *
     * @param string $role Role name
     *
     * @return \Box\Entity\User
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Returns user's enterprise role
     *
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Sets the user's total available space amount in bytes
     *
     * @param integer $space Space in bytes
     *
     * @return \Box\Entity\User
     */
    public function setSpaceAmount($space)
    {
        $this->spaceAmount = $space;

        return $this;
    }

    /**
     * Returns the user's total available space amount in bytes
     *
     * @return integer
     */
    public function getSpaceAmount()
    {
        return $this->spaceAmount;
    }

    /**
     * Sets the amount of space in use by the user
     *
     * @param integer $space Space in bytes
     *
     * @return \Box\Entity\User
     */
    public function setSpaceUsed($space)
    {
        $this->spaceUsed = $space;

        return $this;
    }

    /**
     * Returns the amount of space in use by the user
     *
     * @return integer
     */
    public function getSpaceUsed()
    {
        return $this->spaceUsed;
    }

    /**
     * Sets user's status
     *
     * @param string $status Status: active|inactive
     *
     * @return \Box\Entity\User
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Returns user's status. Can be active or inactive
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Sets an array of key/value pairs set by the user's admin
     *
     * @param mixed $codes Tracking codes
     *
     * @return \Box\Entity\User
     */
    public function setTrackingCodes($codes)
    {
        $this->trackingCodes = Collection::convertToCollection($codes);

        return $this;
    }

    /**
     * Returns an array of key/value pairs set by the user's admin
     *
     * @return Collection|NULL
     */
    public function getTrackingCodes()
    {
        return $this->trackingCodes;
    }
}
