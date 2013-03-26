<?php

namespace AddictedToVintage\EcommerceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AddictedToVintage\EcommerceBundle\Entity\Email
 */
class Email
{
    /**
     * @var integer $id
     */
    protected $id;

    /**
     * @var text $content
     */
    protected $content;

    /**
     * @var datetime $createdAt
     */
    protected $createdAt;

    /**
     * @var string $subject
     */
    protected $subject;

    /**
     * @var AddictedToVintage\EcommerceBundle\Entity\Client
     */
    protected $client;


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
     * Set subject
     *
     * @param string $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * Get subject
     *
     * @return string 
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set client
     *
     * @param AddictedToVintage\EcommerceBundle\Entity\Client $client
     */
    public function setClient(\AddictedToVintage\EcommerceBundle\Entity\Client $client)
    {
        $this->client = $client;
    }

    /**
     * Get client
     *
     * @return AddictedToVintage\EcommerceBundle\Entity\Client 
     */
    public function getClient()
    {
        return $this->client;
    }
}