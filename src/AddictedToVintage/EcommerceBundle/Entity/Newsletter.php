<?php

namespace AddictedToVintage\EcommerceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AddictedToVintage\EcommerceBundle\Entity\Newsletter
 */
class Newsletter
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
     * @var datetime $updatedAt
     */
    protected $updatedAt;

    /**
     * @var datetime $sendAt
     */
    protected $sendAt;

    /**
     * @var string $title
     */
    protected $title;

    /**
     * @var string $campainName
     */
    protected $campainName;

    /**
     * @var text $content
     */
    protected $content;

    /**
     * @var AddictedToVintage\EcommerceBundle\Entity\Client
     */
    protected $clients;
    
    public function __construct() { 
            
        $this->clients = new \Doctrine\Common\Collections\ArrayCollection();
    }


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
     * Set sendAt
     *
     * @param datetime $sendAt
     */
    public function setSendAt($sendAt)
    {
        $this->sendAt = $sendAt;
    }

    /**
     * Get sendAt
     *
     * @return datetime 
     */
    public function getSendAt()
    {
        return $this->sendAt;
    }

    /**
     * Set title
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set campainName
     *
     * @param string $campainName
     */
    public function setCampainName($campainName)
    {
        $this->campainName = $campainName;
    }

    /**
     * Get campainName
     *
     * @return string 
     */
    public function getCampainName()
    {
        return $this->campainName;
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
     * Set clients
     *
     * @param Doctrine\Common\Collections\ArrayCollection $clients
     */
    public function setClients($clients)
    {
        $this->clients = $clients;
    }

    /**
     * Get clients
     *
     * @return Doctrine\Common\Collections\ArrayCollection $clients
     */
    public function getClients()
    {
        return $this->clients;
    }    

}