<?php

namespace Ecommerce\AVBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ecommerce\AVBundle\Entity\CartProducts
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
     * @var Ecommerce\AVBundle\Entity\Product
     */
    protected $product;

    /**
     * @var Ecommerce\AVBundle\Entity\Cart
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
     * @param Ecommerce\AVBundle\Entity\Product $product
     */
    public function setProduct(\Ecommerce\AVBundle\Entity\Product $product)
    {
        $this->product = $product;
    }

    /**
     * Get product
     *
     * @return Ecommerce\AVBundle\Entity\Product 
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set cart
     *
     * @param Ecommerce\AVBundle\Entity\Cart $cart
     */
    public function setCart(\Ecommerce\AVBundle\Entity\Cart $cart)
    {
        $this->cart = $cart;
    }

    /**
     * Get cart
     *
     * @return Ecommerce\AVBundle\Entity\Cart 
     */
    public function getCart()
    {
        return $this->cart;
    }
}