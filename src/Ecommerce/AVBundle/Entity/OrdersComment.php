<?php

namespace Ecommerce\AVBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ecommerce\AVBundle\Entity\OrdersComment
 */
class OrdersComment
{
    /**
     * @var integer $id
     */
    protected $id;

    /**
     * @var date $createdAt
     */
    protected $createdAt;

    /**
     * @var text $content
     */
    protected $content;

    /**
     * @var Ecommerce\AVBundle\Entity\Orders
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
     * @param dateTime $createdAt
     */
    public function setAmount($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Get createdAt
     *
     * @return dateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set content
     *
     * @param text $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * Get content
     *
     * @return text 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set order
     *
     * @param Ecommerce\AVBundle\Entity\Orders $order
     */
    public function setOrder(\Ecommerce\AVBundle\Entity\Orders $order)
    {
        $this->order = $order;
    }

    /**
     * Get order
     *
     * @return Ecommerce\AVBundle\Entity\Orders 
     */
    public function getOrder()
    {
        return $this->order;
    }
}