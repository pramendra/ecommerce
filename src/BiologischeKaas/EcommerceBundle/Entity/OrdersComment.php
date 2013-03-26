<?php

namespace BiologischeKaas\EcommerceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BiologischeKaas\EcommerceBundle\Entity\OrdersComment
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
     * @var BiologischeKaas\EcommerceBundle\Entity\Orders
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
     * @param BiologischeKaas\EcommerceBundle\Entity\Orders $order
     */
    public function setOrder(\BiologischeKaas\EcommerceBundle\Entity\Orders $order)
    {
        $this->order = $order;
    }

    /**
     * Get order
     *
     * @return BiologischeKaas\EcommerceBundle\Entity\Orders 
     */
    public function getOrder()
    {
        return $this->order;
    }
}