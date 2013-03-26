<?php

namespace Ecommerce\AddictedtovintageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ecommerce\AddictedtovintageBundle\Entity\Street
 */
class Street
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
     * @var string $chars
     */
    protected $chars;

    /**
     * @var string $street
     */
    protected $street;

    /**
     * @var boolean $even
     */
    protected $even;

    /**
     * @var integer $low
     */
    protected $low;

    /**
     * @var integer $high
     */
    protected $high;

    /**
     * @var boolean $lowcapped
     */
    protected $lowcapped;

    /**
     * @var boolean $highcapped
     */
    protected $highcapped;

    /**
     * @var decimal $lat
     */
    protected $lat;

    /**
     * @var decimal $lng
     */
    protected $lng;

    /**
     * @var boolean $pobox
     */
    protected $pobox;

    /**
     * @var boolean $unsure
     */
    protected $unsure;

    /**
     * @var string $subtitle
     */
    protected $subtitle;

    /**
     * @var Ecommerce\AddictedtovintageBundle\Entity\Postcode
     */
    protected $postcode;

    /**
     * @var Ecommerce\AddictedtovintageBundle\Entity\Source
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
     * Set chars
     *
     * @param string $chars
     */
    public function setChars($chars)
    {
        $this->chars = $chars;
    }

    /**
     * Get chars
     *
     * @return string 
     */
    public function getChars()
    {
        return $this->chars;
    }

    /**
     * Set street
     *
     * @param string $street
     */
    public function setStreet($street)
    {
        $this->street = $street;
    }

    /**
     * Get street
     *
     * @return string 
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set even
     *
     * @param boolean $even
     */
    public function setEven($even)
    {
        $this->even = $even;
    }

    /**
     * Get even
     *
     * @return boolean 
     */
    public function getEven()
    {
        return $this->even;
    }

    /**
     * Set low
     *
     * @param integer $low
     */
    public function setLow($low)
    {
        $this->low = $low;
    }

    /**
     * Get low
     *
     * @return integer 
     */
    public function getLow()
    {
        return $this->low;
    }

    /**
     * Set high
     *
     * @param integer $high
     */
    public function setHigh($high)
    {
        $this->high = $high;
    }

    /**
     * Get high
     *
     * @return integer 
     */
    public function getHigh()
    {
        return $this->high;
    }

    /**
     * Set lowcapped
     *
     * @param boolean $lowcapped
     */
    public function setLowcapped($lowcapped)
    {
        $this->lowcapped = $lowcapped;
    }

    /**
     * Get lowcapped
     *
     * @return boolean 
     */
    public function getLowcapped()
    {
        return $this->lowcapped;
    }

    /**
     * Set highcapped
     *
     * @param boolean $highcapped
     */
    public function setHighcapped($highcapped)
    {
        $this->highcapped = $highcapped;
    }

    /**
     * Get highcapped
     *
     * @return boolean 
     */
    public function getHighcapped()
    {
        return $this->highcapped;
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
     * Set pobox
     *
     * @param boolean $pobox
     */
    public function setPobox($pobox)
    {
        $this->pobox = $pobox;
    }

    /**
     * Get pobox
     *
     * @return boolean 
     */
    public function getPobox()
    {
        return $this->pobox;
    }

    /**
     * Set unsure
     *
     * @param boolean $unsure
     */
    public function setUnsure($unsure)
    {
        $this->unsure = $unsure;
    }

    /**
     * Get unsure
     *
     * @return boolean 
     */
    public function getUnsure()
    {
        return $this->unsure;
    }

    /**
     * Set subtitle
     *
     * @param string $subtitle
     */
    public function setSubtitle($subtitle)
    {
        $this->subtitle = $subtitle;
    }

    /**
     * Get subtitle
     *
     * @return string 
     */
    public function getSubtitle()
    {
        return $this->subtitle;
    }

    /**
     * Set postcode
     *
     * @param Ecommerce\AddictedtovintageBundle\Entity\Postcode $postcode
     */
    public function setPostcode(\Ecommerce\AddictedtovintageBundle\Entity\Postcode $postcode)
    {
        $this->postcode = $postcode;
    }

    /**
     * Get postcode
     *
     * @return Ecommerce\AddictedtovintageBundle\Entity\Postcode 
     */
    public function getPostcode()
    {
        return $this->postcode;
    }

    /**
     * Set source
     *
     * @param Ecommerce\AddictedtovintageBundle\Entity\Source $source
     */
    public function setSource(\Ecommerce\AddictedtovintageBundle\Entity\Source $source)
    {
        $this->source = $source;
    }

    /**
     * Get source
     *
     * @return Ecommerce\AddictedtovintageBundle\Entity\Source 
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