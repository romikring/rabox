<?php
/**
 * Description of UploadEmail
 *
 * @author Roman Habrusionok <romikring@gmail.com>
 */
namespace Box\Storage;

class UploadEmail
{
    /**
     * Access
     *
     * @var string
     */
    protected $access;
    /**
     * Email
     *
     * @var string
     */
    protected $email;

    /**
     * Sets access
     *
     * @param string $access
     *
     * @return \Box\Storage\UploadEmail
     */
    public function setAccess($access)
    {
        $this->access = $access;

        return $this;
    }

    /**
     * Returns access
     *
     * @return string
     */
    public function getAccess()
    {
        return $this->access;
    }

    /**
     * Sets Email
     *
     * @param string $email
     *
     * @return \Box\Storage\UploadEmail
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Returns Email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    public function convertToUploadEmail($email)
    {
        return new self();
    }
}
