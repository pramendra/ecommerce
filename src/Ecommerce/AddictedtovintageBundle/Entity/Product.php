<?php

namespace Ecommerce\AddictedtovintageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ecommerce\AddictedtovintageBundle\Entity\Product
 */
class Product {

    /**
     * @var integer $id
     */
    protected $id;

    /**
     * @var string $name
     */
    protected $name;

    /**
     * @var text $description
     */
    protected $description;

    /**
     * @var string $sku
     */
    protected $sku;

    /**
     * @var string $keywords
     */
    protected $keywords;

    /**
     * @var decimal $salePrice
     */
    protected $salePrice;

    /**
     * @var decimal $price
     */
    protected $price;

    /**
     * @var datetime $createdAt
     */
    protected $createdAt;

    /**
     * @var datetime $updatedAt
     */
    protected $updatedAt;

    /**
     * @var datetime $deletedAt
     */
    protected $deletedAt;

    /**
     * @var datetime $soldAt
     */
    protected $soldAt;

    /**
     * @var string $permalink
     */
    protected $permalink;

    /**
     * @var integer $stock
     */
    protected $stock;

    /**
     * @var integer $views
     */
    protected $views;

    /**
     * @var boolean $isNew
     */
    protected $isNew;

    /**
     * @var integer $active
     */
    protected $active;

    /**
     * @var boolean $isSale
     */
    protected $isSale;

    /**
     * @var integer $weight
     */
    protected $weight;

    /*
     * @var integer $firstImage
     */
    protected $firstImage;

    /*
     * @var Ecommerce\AddictedtovintageBundle\Entity\ShippingTypes $shippingType
     */
    protected $shippingType;

    /*
     * @var Ecommerce\AddictedtovintageBundle\Entity\ProductImages $images
     */
    protected $images;

    /**
     * @var Ecommerce\AddictedtovintageBundle\Entity\ProductAttributes
     */
    protected $attributes;

    /**
     * @var Ecommerce\AddictedtovintageBundle\Entity\Subcategories
     */
    protected $subcategories;

    public function __construct() {

        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
        $this->attributes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->subcategories = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set description
     *
     * @param text $description
     */
    public function setDescription($description) {
        $this->description = $description;
    }

    /**
     * Get description
     *
     * @return text 
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Set sku
     *
     * @param string $sku
     */
    public function setSku($sku) {
        $this->sku = $sku;
    }

    /**
     * Get sku
     *
     * @return string 
     */
    public function getSku() {
        return $this->sku;
    }

    /**
     * Set keywords
     *
     * @param string $keywords
     */
    public function setKeywords($keywords) {
        $this->keywords = $keywords;
    }

    /**
     * Get keywords
     *
     * @return string 
     */
    public function getKeywords() {
        return $this->keywords;
    }

    /**
     * Set salePrice
     *
     * @param decimal $salePrice
     */
    public function setSalePrice($salePrice) {
        $this->salePrice = $salePrice;
    }

    /**
     * Get salePrice
     *
     * @return decimal 
     */
    public function getSalePrice() {
        return $this->salePrice;
    }

    /**
     * Set price
     *
     * @param decimal $price
     */
    public function setPrice($price) {
        $this->price = $price;
    }

    /**
     * Get price
     *
     * @return decimal 
     */
    public function getPrice() {
        return $this->price;
    }

    /**
     * Set createdAt
     *
     * @param datetime $createdAt
     */
    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;
    }

    /**
     * Get createdAt
     *
     * @return datetime 
     */
    public function getCreatedAt() {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param datetime $updatedAt
     */
    public function setUpdatedAt($updatedAt) {
        $this->updatedAt = $updatedAt;
    }

    /**
     * Get updatedAt
     *
     * @return datetime 
     */
    public function getUpdatedAt() {
        return $this->updatedAt;
    }

    /**
     * Set deletedAt
     *
     * @param datetime $deletedAt
     */
    public function setDeletedAt($deletedAt) {
        $this->deletedAt = $deletedAt;
    }

    /**
     * Get deletedAt
     *
     * @return datetime 
     */
    public function getDeletedAt() {
        return $this->deletedAt;
    }

    /**
     * Set soldAt
     *
     * @param datetime $soldAt
     */
    public function setSoldAt($soldAt) {
        $this->soldAt = $soldAt;
    }

    /**
     * Get soldAt
     *
     * @return datetime 
     */
    public function getSoldAt() {
        return $this->soldAt;
    }

    /**
     * Set permalink
     *
     * @param string $permalink
     */
    public function setPermalink($permalink) {
        $this->permalink = $permalink;
    }

    /**
     * Get permalink
     *
     * @return string 
     */
    public function getPermalink() {
        return $this->permalink;
    }

    /**
     * Set stock
     *
     * @param integer $stock
     */
    public function setStock($stock) {
        $this->stock = $stock;
    }

    /**
     * Get stock
     *
     * @return integer 
     */
    public function getStock() {
        return $this->stock;
    }

    /**
     * Set views
     *
     * @param integer $views
     */
    public function setViews($views) {
        $this->views = $views;
    }

    /**
     * Get views
     *
     * @return integer 
     */
    public function getViews() {
        return $this->views;
    }

    /**
     * Set isNew
     *
     * @param boolean $isNew
     */
    public function setIsNew($isNew) {
        $this->isNew = $isNew;
    }

    /**
     * Get isNew
     *
     * @return boolean 
     */
    public function getIsNew() {
        return $this->isNew;
    }

    /**
     * Set active
     *
     * @param integer $active
     */
    public function setActive($active) {
        $this->active = $active;
    }

    /**
     * Get active
     *
     * @return integer 
     */
    public function getActive() {
        return $this->active;
    }

    /**
     * Set isSale
     *
     * @param boolean $isSale
     */
    public function setIsSale($isSale) {
        $this->isSale = $isSale;
    }

    /**
     * Get isSale
     *
     * @return boolean 
     */
    public function getIsSale() {
        return $this->isSale;
    }

    /**
     * Set weight
     *
     * @param integer $weight
     */
    public function setWeight($weight) {
        $this->weight = $weight;
    }

    /**
     * Get weight
     *
     * @return integer 
     */
    public function getWeight() {
        return $this->weight;
    }

    /**
     * Add images
     *
     * @param Ecommerce\AddictedtovintageBundle\Entity\ProductImages $images
     */
    public function addImages(\Ecommerce\AddictedtovintageBundle\Entity\ProductImages $images) {

        $this->images = $images;
    }

    /**
     * Set images
     *
     * @param Doctrine\Common\Collections\ArrayCollection $images
     */
    public function setImages($images) {
        $this->images = $images;
    }

    /**
     * Get images
     *
     * @return Doctrine\Common\Collections\ArrayCollection $images
     */
    public function getImages() {
        return $this->images;
    }

    /**
     * Set firstImage
     *
     * @param integer $firstImage
     */
    public function setFirstImage($image) {
        $this->firstImage = $image;
    }

    /**
     * Get firstImage
     *
     * @return integer
     */
    public function getFirstImage() {
        
        foreach($this->images as $image) { 
            if($image->getId() == $this->firstImage) { 
                return $image;
            }
        }
        
        return null;
    }

    /**
     * Set shippingType
     *
     * @param Ecommerce\AddictedtovintageBundle\Entity\ShippingTypes $shipping
     */
    public function setShippingType(\Ecommerce\AddictedtovintageBundle\Entity\ShippingTypes $shipping_type) {
        $this->shippingType = $shipping_type;
    }

    /**
     * Get shippingType
     *
     * @return @param Ecommerce\AddictedtovintageBundle\Entity\ShippingTypes
     */
    public function getShippingType() {
        return $this->shippingType;
    }

    /**
     * Add attributes
     *
     * @param Ecommerce\AddictedtovintageBundle\Entity\ProductAttributes $attributes
     */
    public function addAttributes(\Ecommerce\AddictedtovintageBundle\Entity\ProductAttributes $attributes) {

        $this->attributes[] = $attributes;
    }

    /**
     * Set attributes
     *
     * @param \Doctrine\Common\Collections\Collection $attributes
     */
    public function setAttributes(\Doctrine\Common\Collections\Collection $attributes) {
        $this->attributes[] = $attributes;
    }

    /**
     * Get attributes
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getAttributes() {
        return $this->attributes;
    }

    /**
     * Add subcategories
     *
     * @param Ecommerce\AddictedtovintageBundle\Entity\Subcategory $subcategories
     */
    public function addSubcategories(\Ecommerce\AddictedtovintageBundle\Entity\Subcategory $subcategories) {
        $this->subcategories[] = $subcategories;
    }

    /**
     * Set subcategories
     *
     * @param Doctrine\Common\Collections\ArrayCollection $subcategories
     */
    public function setSubcategories($subcategories) {
        $this->subcategories = $subcategories;
    }

    /**
     * Get subcategories
     *
     * @return Doctrine\Common\Collections\ArrayCollection $subcategories
     */
    public function getSubcategories() {
        return $this->subcategories;
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