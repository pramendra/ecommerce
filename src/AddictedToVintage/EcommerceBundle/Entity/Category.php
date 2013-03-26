<?php

namespace AddictedToVintage\EcommerceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AddictedToVintage\EcommerceBundle\Entity\Category
 */
class Category
{
    /**
     * @var integer $id
     */
    protected $id;

    /**
     * @var string $name
     */
    protected $name;

    /**
     * @var text $description
     */
    protected $description;

    /**
     * @var string $keywords
     */
    protected $keywords;

    /**
     * @var string $image
     */
    protected $image;

    /**
     * @var string $permalink
     */
    protected $permalink;

    /**
     * @var integer $active
     */
    protected $active;
    
    /*
     * @var AddictedToVintage\EcommerceBundle\Entity\Subcategory $subcategories
     */
    protected $subcategories;
    
    /*
     * @var AddictedToVintage\EcommerceBundle\Entity\Section $sections
     */
    protected $sections;
    
    
    public function __construct() { 
            
        $this->subcategories = new \Doctrine\Common\Collections\ArrayCollection();
        $this->sections = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param text $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get description
     *
     * @return text 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set keywords
     *
     * @param string $keywords
     */
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;
    }

    /**
     * Get keywords
     *
     * @return string 
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * Set image
     *
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set permalink
     *
     * @param string $permalink
     */
    public function setPermalink($permalink)
    {
        $this->permalink = $permalink;
    }

    /**
     * Get permalink
     *
     * @return string 
     */
    public function getPermalink()
    {
        return $this->permalink;
    }

    /**
     * Set active
     *
     * @param integer $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * Get active
     *
     * @return integer 
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set subcategories
     *
     * @param Doctrine\Common\Collections\ArrayCollection $subcategories
     */
    public function setSubcategories($subcategories)
    {
        $this->subcategories = $subcategories;
    }

    /**
     * Get subcategories
     *
     * @return Doctrine\Common\Collections\ArrayCollection $subcategories
     */
    public function getSubcategories()
    {
        return $this->subcategories;
    }

    /**
     * add section
     *
     * @param @var AddictedToVintage\EcommerceBundle\Entity\Section $section
     */
    public function addSections($section)
    {
        $this->sections[] = $section;
    }

    /**
     * Set sections
     *
     * @param Doctrine\Common\Collections\ArrayCollection $sections
     */
    public function setSections($sections)
    {
        $this->sections = $sections;
    }

    /**
     * Get sections
     *
     * @return Doctrine\Common\Collections\ArrayCollection $sections
     */
    public function getSections()
    {
        return $this->sections;
    }
    
    public function __toString() 
    {
        return $this->name;
    }
}