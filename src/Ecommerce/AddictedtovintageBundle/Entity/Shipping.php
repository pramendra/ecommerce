<?php

namespace Ecommerce\AddictedtovintageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ecommerce\AddictedtovintageBundle\Entity\Shipping
 */
class Shipping {

    /**
     * @var integer $id
     */
    protected $id;

    /**
     * @var string $name
     */
    protected $name;

    /**
     * @var float $costs
     */
    protected $costs;

    /**
     * @var string $description
     */
    protected $description;

    /**
     * @var Ecommerce\AddictedtovintageBundle\Entity\ShippingTypes $shippingType
     * 
     */
    protected $shippingType;

    /**
     * @var boolean $active
     */
    protected $active;

    /**
     * @var integer $isChecked
     */
    protected $isChecked;

    /**
     * @var string $country
     */
    protected $country;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set costs
     *
     * @param float $costs
     */
    public function setCosts($costs) {
        $this->costs = $costs;
    }

    /**
     * Get costs
     *
     * @return float 
     */
    public function getCosts() {
        return $this->costs;
    }

    /**
     * Set description
     *
     * @param string $description
     */
    public function setDescription($description) {
        $this->description = $description;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Set shippingType
     *
     * @param Ecommerce\AddictedtovintageBundle\Entity\ShippingTypes $shippingType
     */
    public function setShippingType(ShippingTypes $shippingType) {
        $this->shippingType = $shippingType;
    }

    /**
     * Get shippingType
     *
     * @return Ecommerce\AddictedtovintageBundle\Entity\ShippingTypes
     */
    public function getShippingType() {
        return $this->shippingType;
    }

    /**
     * Set active
     *
     * @param boolean $active
     */
    public function setActive($active) {
        $this->active = $active;
    }

    /**
     * Get active
     *
     * @return boolean 
     */
    public function getActive() {
        return $this->active;
    }

    /**
     * Set isChecked
     *
     * @param integer $isChecked
     */
    public function setIsChecked($isChecked) {
        $this->isChecked = $isChecked;
    }

    /**
     * Get isChecked
     *
     * @return integer 
     */
    public function getIsChecked() {
        return $this->isChecked;
    }
    
    
    /**
     * Set country
     *
     * @param string $country
     */
    public function setCountry($country) {
        $this->country = $country;
    }

    /**
     * Get country
     *
     * @return string 
     */
    public function getCountry() {
        return $this->country;
    }

    function __toString() {
        return $this->name;
    }

    function __toJson() {
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