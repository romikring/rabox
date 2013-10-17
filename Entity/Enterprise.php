<?php
/**
 * Description of Enterprise
 *
 * @author Roman Habrusionok <romikring@gmail.com>
 */
namespace Box\Entity;

class Enterprise
{
    /**
     * @var string
     */
    protected $id;
    /**
     * @var string
     */
    protected $name;
    /**
     * @var string
     */
    protected $type;

    /**
     * Sets ID
     *
     * @param string $id ID
     *
     * @return \Box\Entity\Enterprise
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Returns ID
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets name
     *
     * @param String $name Name
     *
     * @return \Box\Entity\Type\Enterprise
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Returns name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets type
     *
     * @param string $type Type
     *
     * @return \Box\Entity\Type\Enterprise
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Returns type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}
