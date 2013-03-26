<?php

namespace Ecommerce\BiologischekaasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ecommerce\BiologischekaasBundle\Entity\Postcode
 */
class Postcode
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
     * @var integer $fourpp
     */
    protected $fourpp;

    /**
     * @var decimal $lat
     */
    protected $lat;

    /**
     * @var decimal $lng
     */
    protected $lng;

    /**
     * @var Ecommerce\BiologischekaasBundle\Entity\City
     */
    protected $city;

    /**
     * @var Ecommerce\BiologischekaasBundle\Entity\Source
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
     * Set fourpp
     *
     * @param integer $fourpp
     */
    public function setFourpp($fourpp)
    {
        $this->fourpp = $fourpp;
    }

    /**
     * Get fourpp
     *
     * @return integer 
     */
    public function getFourpp()
    {
        return $this->fourpp;
    }

    /**
     * Set lat
     *
     * @param decimal $lat
     */
    public function setLat($lat)
    {
        $this->lat = $lat;
    }

    /**
     * Get lat
     *
     * @return decimal 
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * Set lng
     *
     * @param decimal $lng
     */
    public function setLng($lng)
    {
        $this->lng = $lng;
    }

    /**
     * Get lng
     *
     * @return decimal 
     */
    public function getLng()
    {
        return $this->lng;
    }

    /**
     * Set city
     *
     * @param Ecommerce\BiologischekaasBundle\Entity\City $city
     */
    public function setCity(\Ecommerce\BiologischekaasBundle\Entity\City $city)
    {
        $this->city = $city;
    }

    /**
     * Get city
     *
     * @return Ecommerce\BiologischekaasBundle\Entity\City 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set source
     *
     * @param Ecommerce\BiologischekaasBundle\Entity\Source $source
     */
    public function setSource(\Ecommerce\BiologischekaasBundle\Entity\Source $source)
    {
        $this->source = $source;
    }

    /**
     * Get source
     *
     * @return Ecommerce\BiologischekaasBundle\Entity\Source 
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