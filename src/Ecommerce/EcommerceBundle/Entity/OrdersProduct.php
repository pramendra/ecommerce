<?php

namespace Ecommerce\EcommerceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ecommerce\EcommerceBundle\Entity\OrdersProduct
 */
class OrdersProduct
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
     * @var float $totalPrice
     */
    protected $totalPrice;

    /**
     * @var text $productHistory
     */
    protected $productHistory;

    /**
     * @var Ecommerce\EcommerceBundle\Entity\Product
     */
    protected $product;

    /**
     * @var Ecommerce\EcommerceBundle\Entity\Orders
     */
    protected $order;


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
     * Set totalPrice
     *
     * @param float $totalPrice
     */
    public function setTotalPrice($totalPrice)
    {
        $this->totalPrice = $totalPrice;
    }

    /**
     * Get totalPrice
     *
     * @return float 
     */
    public function getTotalPrice()
    {
        return $this->totalPrice;
    }

    /**
     * Set productHistory
     *
     * @param text $productHistory
     */
    public function setProductHistory($productHistory)
    {
        $this->productHistory = $productHistory;
    }

    /**
     * Get productHistory
     *
     * @return text 
     */
    public function getProductHistory()
    {
        return $this->productHistory;
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
     * Set order
     *
     * @param Ecommerce\EcommerceBundle\Entity\Orders $order
     */
    public function setOrder(\Ecommerce\EcommerceBundle\Entity\Orders $order)
    {
        $this->order = $order;
    }

    /**
     * Get order
     *
     * @return Ecommerce\EcommerceBundle\Entity\Orders 
     */
    public function getOrder()
    {
        return $this->order;
    }
}