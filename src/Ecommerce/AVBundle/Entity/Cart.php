<?php

namespace Ecommerce\AVBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ecommerce\AVBundle\Entity\Cart
 */
class Cart {

    /**
     * @var integer $id
     */
    protected $id;

    /**
     * @var float $totalPriceInc
     */
    protected $totalPriceInc;

    /**
     * @var float $totalPriceEx
     */
    protected $totalPriceEx;

    /**
     * @var integer $numProducts
     */
    protected $numProducts;

    /**
     * @var string $sessionId
     */
    protected $sessionId;

    /**
     * @var datetime $updatedAt
     */
    protected $updatedAt;

    /**
     * @var datetime $createdAt
     */
    protected $createdAt;

    /**
     * @var Ecommerce\AVBundle\Entity\Shipping
     */
    protected $shipping;

    /**
     * @var Ecommerce\AVBundle\Entity\Client
     */
    protected $client;

    /**
     * @var Ecommerce\AVBundle\Entity\CartProducts
     */
    protected $products;

    /**
     * @var Ecommerce\AVBundle\Entity\Coupon
     */
    protected $coupon;
    

    public function __construct() {

        $this->products = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set totalPriceInc
     *
     * @param float $totalPriceInc
     */
    public function setTotalPriceInc($totalPriceInc) {
        $this->totalPriceInc = $totalPriceInc;
    }

    /**
     * Get totalPriceInc
     *
     * @return float 
     */
    public function getTotalPriceInc() {
        return $this->totalPriceInc;
    }

    /**
     * Set totalPriceEx
     *
     * @param float $totalPriceEx
     */
    public function setTotalPriceEx($totalPriceEx) {
        $this->totalPriceEx = $totalPriceEx;
    }

    /**
     * Get totalPriceEx
     *
     * @return float 
     */
    public function getTotalPriceEx() {
        return $this->totalPriceEx;
    }

    /**
     * Set numProducts
     *
     * @param integer $numProducts
     */
    public function setNumProducts($numProducts) {
        $this->numProducts = $numProducts;
    }

    /**
     * Get numProducts
     *
     * @return integer 
     */
    public function getNumProducts() {
        return $this->numProducts;
    }

    /**
     * Set sessionId
     *
     * @param string $sessionId
     */
    public function setSessionId($sessionId) {
        $this->sessionId = $sessionId;
    }

    /**
     * Get sessionId
     *
     * @return string 
     */
    public function getSessionId() {
        return $this->sessionId;
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
     * Set shipping
     *
     * @param Ecommerce\AVBundle\Entity\Shipping $shipping
     */
    public function setShipping(\Ecommerce\AVBundle\Entity\Shipping $shipping) {
        $this->shipping = $shipping;
    }

    /**
     * Get shipping
     *
     * @return Ecommerce\AVBundle\Entity\Shipping 
     */
    public function getShipping() {
        return $this->shipping;
    }

    /**
     * Set coupon
     *
     * @param Ecommerce\AVBundle\Entity\Coupon $coupon
     */
    public function setCoupon(\Ecommerce\AVBundle\Entity\Coupon $coupon) {
        $this->coupon = $coupon;
    }

    /**
     * Get coupon
     *
     * @return Ecommerce\AVBundle\Entity\Coupon 
     */
    public function getCoupon() {
        return $this->coupon;
    }

    /**
     * Set client
     *
     * @param Ecommerce\AVBundle\Entity\Client $client
     */
    public function setClient(\Ecommerce\AVBundle\Entity\Client $client) {
        $this->client = $client;
    }

    /**
     * Get client
     *
     * @return Ecommerce\AVBundle\Entity\Client 
     */
    public function getClient() {
        return $this->client;
    }

    /**
     * Add product
     *
     * @param Ecommerce\AVBundle\Entity\CartProducts $product
     */
    public function addProduct(\Ecommerce\AVBundle\Entity\CartProducts $product) {
		$product->setCart($this);
        $this->products[] = $product;
    }

    /**
     * Set products
     *
     * @param Doctrine\Common\Collections\ArrayCollection $products
     */
    public function setProducts(\Doctrine\Common\Collections\ArrayCollection $products) {
        $this->products = $products;
    }

    /**
     * Get products
     *
     * @return Doctrine\Common\Collections\ArrayCollection
     */
    public function getProducts() {
        return $this->products;
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