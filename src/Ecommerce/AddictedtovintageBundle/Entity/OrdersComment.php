<?php

namespace Ecommerce\AddictedtovintageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ecommerce\AddictedtovintageBundle\Entity\OrdersComment
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
     * @var Ecommerce\AddictedtovintageBundle\Entity\Orders
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
     * @param Ecommerce\AddictedtovintageBundle\Entity\Orders $order
     */
    public function setOrder(\Ecommerce\AddictedtovintageBundle\Entity\Orders $order)
    {
        $this->order = $order;
    }

    /**
     * Get order
     *
     * @return Ecommerce\AddictedtovintageBundle\Entity\Orders 
     */
    public function getOrder()
    {
        return $this->order;
    }
}