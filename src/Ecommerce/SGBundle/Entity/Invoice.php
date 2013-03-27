<?php

namespace Ecommerce\SGBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ecommerce\SGBundle\Entity\Invoice
 */
class Invoice
{
    /**
     * @var integer $id
     */
    protected $id;

    /**
     * @var datetime $createdAt
     */
    protected $createdAt;

    /**
     * @var float $totalPrice
     */
    protected $totalPrice;

    /**
     * @var float $tax
     */
    protected $tax;

    /**
     * @var integer $payed
     */
    protected $payed;

    /**
     * @var Ecommerce\SGBundle\Entity\Client
     */
    protected $client;

    /**
     * @var Ecommerce\SGBundle\Entity\Orders
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
     * Set tax
     *
     * @param float $tax
     */
    public function setTax($tax)
    {
        $this->tax = $tax;
    }

    /**
     * Get tax
     *
     * @return float 
     */
    public function getTax()
    {
        return $this->tax;
    }

    /**
     * Set payed
     *
     * @param integer $payed
     */
    public function setPayed($payed)
    {
        $this->payed = $payed;
    }

    /**
     * Get payed
     *
     * @return integer 
     */
    public function getPayed()
    {
        return $this->payed;
    }

    /**
     * Set client
     *
     * @param Ecommerce\SGBundle\Entity\Client $client
     */
    public function setClient(\Ecommerce\SGBundle\Entity\Client $client)
    {
        $this->client = $client;
    }

    /**
     * Get client
     *
     * @return Ecommerce\SGBundle\Entity\Client 
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set order
     *
     * @param Ecommerce\SGBundle\Entity\Orders $order
     */
    public function setOrder(\Ecommerce\SGBundle\Entity\Orders $order)
    {
        $this->order = $order;
    }

    /**
     * Get order
     *
     * @return Ecommerce\SGBundle\Entity\Orders 
     */
    public function getOrder()
    {
        return $this->order;
    }
}