<?php

namespace Ecommerce\AVBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ecommerce\AVBundle\Entity\Attribute
 */
class Attribute {

    /**
     * @var integer $id
     */
    protected $id;

    /**
     * @var string $name
     */
    protected $name;

    /**
     * @var boolean $isFilterable
     */
    protected $isFilterable;

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
     * Set is_filterable
     *
     * @param boolean $isFilterable
     */
    public function setIsFilterable($is_filterable) {
        $this->isFilterable = $is_filterable;
    }

    /**
     * Get is_filterable
     *
     * @return boolean 
     */
    public function getIsFilterable() {
        return $this->isFilterable;
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