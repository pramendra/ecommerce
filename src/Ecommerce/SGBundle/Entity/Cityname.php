<?php

namespace Ecommerce\SGBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ecommerce\SGBundle\Entity\Cityname
 */
class Cityname
{
    /**
     * @var integer $id
     */
    protected $id;

    /**
     * @var datetime $created
     */
    protected $created;

    /**
     * @var datetime $updated
     */
    protected $updated;

    /**
     * @var boolean $active
     */
    protected $active;

    /**
     * @var string $name
     */
    protected $name;

    /**
     * @var boolean $official
     */
    protected $official;

    /**
     * @var Ecommerce\SGBundle\Entity\City
     */
    protected $city;

    /**
     * @var Ecommerce\SGBundle\Entity\Source
     */
    protected $source;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set created
     *
     * @param datetime $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * Get created
     *
     * @return datetime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param datetime $updated
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }

    /**
     * Get updated
     *
     * @return datetime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set active
     *
     * @param boolean $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * Get active
     *
     * @return boolean 
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set official
     *
     * @param boolean $official
     */
    public function setOfficial($official)
    {
        $this->official = $official;
    }

    /**
     * Get official
     *
     * @return boolean 
     */
    public function getOfficial()
    {
        return $this->official;
    }

    /**
     * Set city
     *
     * @param Ecommerce\SGBundle\Entity\City $city
     */
    public function setCity(\Ecommerce\SGBundle\Entity\City $city)
    {
        $this->city = $city;
    }

    /**
     * Get city
     *
     * @return Ecommerce\SGBundle\Entity\City 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set source
     *
     * @param Ecommerce\SGBundle\Entity\Source $source
     */
    public function setSource(\Ecommerce\SGBundle\Entity\Source $source)
    {
        $this->source = $source;
    }

    /**
     * Get source
     *
     * @return Ecommerce\SGBundle\Entity\Source 
     */
    public function getSource()
    {
        return $this->source;
    }

	function __toJson()
	{
		$json = new \stdClass();

		foreach ($this as $key => $value) {
			if (is_object($value)) {
				if (method_exists($value, '__toJson')) {
					$json->$key = $value->__toJson();
				}
			} else {
				$json->$key = $value;
			}
		}
		return $json;
	}
}