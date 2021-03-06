<?php

namespace Ecommerce\SGBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ecommerce\SGBundle\Entity\City
 */
class City
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
     * @var integer $municipalityCode
     */
    protected $municipalityCode;

    /**
     * @var decimal $lat
     */
    protected $lat;

    /**
     * @var decimal $lng
     */
    protected $lng;

    /**
     * @var string $areacode
     */
    protected $areacode;

    /**
     * @var Ecommerce\SGBundle\Entity\City
     */
    protected $municipality;

    /**
     * @var Ecommerce\SGBundle\Entity\Province
     */
    protected $province;

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
     * Set municipalityCode
     *
     * @param integer $municipalityCode
     */
    public function setMunicipalityCode($municipalityCode)
    {
        $this->municipalityCode = $municipalityCode;
    }

    /**
     * Get municipalityCode
     *
     * @return integer 
     */
    public function getMunicipalityCode()
    {
        return $this->municipalityCode;
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
     * Set areacode
     *
     * @param string $areacode
     */
    public function setAreacode($areacode)
    {
        $this->areacode = $areacode;
    }

    /**
     * Get areacode
     *
     * @return string 
     */
    public function getAreacode()
    {
        return $this->areacode;
    }

    /**
     * Set municipality
     *
     * @param Ecommerce\SGBundle\Entity\City $municipality
     */
    public function setMunicipality(\Ecommerce\SGBundle\Entity\City $municipality)
    {
        $this->municipality = $municipality;
    }

    /**
     * Get municipality
     *
     * @return Ecommerce\SGBundle\Entity\City 
     */
    public function getMunicipality()
    {
        return $this->municipality;
    }

    /**
     * Set province
     *
     * @param Ecommerce\SGBundle\Entity\Province $province
     */
    public function setProvince(\Ecommerce\SGBundle\Entity\Province $province)
    {
        $this->province = $province;
    }

    /**
     * Get province
     *
     * @return Ecommerce\SGBundle\Entity\Province 
     */
    public function getProvince()
    {
        return $this->province;
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