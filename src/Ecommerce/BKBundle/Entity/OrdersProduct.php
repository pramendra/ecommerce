<?php

namespace Ecommerce\BKBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ecommerce\BKBundle\Entity\OrdersProduct
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
     * @var Ecommerce\BKBundle\Entity\Product
     */
    protected $product;

    /**
     * @var Ecommerce\BKBundle\Entity\Orders
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
     * @param Ecommerce\BKBundle\Entity\Product $product
     */
    public function setProduct(\Ecommerce\BKBundle\Entity\Product $product)
    {
        $this->product = $product;
    }

    /**
     * Get product
     *
     * @return Ecommerce\BKBundle\Entity\Product 
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set order
     *
     * @param Ecommerce\BKBundle\Entity\Orders $order
     */
    public function setOrder(\Ecommerce\BKBundle\Entity\Orders $order)
    {
        $this->order = $order;
    }

    /**
     * Get order
     *
     * @return Ecommerce\BKBundle\Entity\Orders 
     */
    public function getOrder()
    {
        return $this->order;
    }
}