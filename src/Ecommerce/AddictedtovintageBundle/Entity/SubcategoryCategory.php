<?php

namespace Ecommerce\AddictedtovintageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ecommerce\AddictedtovintageBundle\Entity\SubcategoryCategory
 */
class SubcategoryCategory
{
    /**
     * @var integer $id
     */
    protected $id;

    /**
     * @var Ecommerce\AddictedtovintageBundle\Entity\Subcategory
     */
    protected $subcategory;

    /**
     * @var Ecommerce\AddictedtovintageBundle\Entity\Category
     */
    protected $category;


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
     * Set subcategory
     *
     * @param Ecommerce\AddictedtovintageBundle\Entity\Subcategory $subcategory
     */
    public function setSubcategory(\Ecommerce\AddictedtovintageBundle\Entity\Subcategory $subcategory)
    {
        $this->subcategory = $subcategory;
    }

    /**
     * Get subcategory
     *
     * @return Ecommerce\AddictedtovintageBundle\Entity\Subcategory 
     */
    public function getSubcategory()
    {
        return $this->subcategory;
    }

    /**
     * Set category
     *
     * @param Ecommerce\AddictedtovintageBundle\Entity\Category $category
     */
    public function setCategory(\Ecommerce\AddictedtovintageBundle\Entity\Category $category)
    {
        $this->category = $category;
    }

    /**
     * Get category
     *
     * @return Ecommerce\AddictedtovintageBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }
}