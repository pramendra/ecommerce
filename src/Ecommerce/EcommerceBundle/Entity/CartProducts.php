<?php

namespace Ecommerce\EcommerceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ecommerce\EcommerceBundle\Entity\CartProducts
 */
class CartProducts
{
    /**
     * @var integer $id
     */
    protected $id;

    /**
     * @var integer $amount
     */
    protected $amount;

    /**
     * @var float $price
     */
    protected $price;

    /**
     * @var datetime $updatedAt
     */
    protected $updatedAt;

    /**
     * @var datetime $createdAt
     */
    protected $createdAt;

    /**
     * @var Ecommerce\EcommerceBundle\Entity\Product
     */
    protected $product;

    /**
     * @var Ecommerce\EcommerceBundle\Entity\Cart
     */
    protected $cart;


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
     * Set amount
     *
     * @param integer $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * Get amount
     *
     * @return integer 
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set price
     *
     * @param float $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * Get price
     *
     * @return float 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set updatedAt
     *
     * @param datetime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * Get updatedAt
     *
     * @return datetime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set createdAt
     *
     * @param datetime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Get createdAt
     *
     * @return datetime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set product
     *
     * @param Ecommerce\EcommerceBundle\Entity\Product $product
     */
    public function setProduct(\Ecommerce\EcommerceBundle\Entity\Product $product)
    {
        $this->product = $product;
    }

    /**
     * Get product
     *
     * @return Ecommerce\EcommerceBundle\Entity\Product 
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set cart
     *
     * @param Ecommerce\EcommerceBundle\Entity\Cart $cart
     */
    public function setCart(\Ecommerce\EcommerceBundle\Entity\Cart $cart)
    {
        $this->cart = $cart;
    }

    /**
     * Get cart
     *
     * @return Ecommerce\EcommerceBundle\Entity\Cart 
     */
    public function getCart()
    {
        return $this->cart;
    }
}