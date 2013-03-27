<?php

namespace Ecommerce\EcommerceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ecommerce\EcommerceBundle\Entity\SubcategoryCategory
 */
class SubcategoryCategory
{
    /**
     * @var integer $id
     */
    protected $id;

    /**
     * @var Ecommerce\EcommerceBundle\Entity\Subcategory
     */
    protected $subcategory;

    /**
     * @var Ecommerce\EcommerceBundle\Entity\Category
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
     * @param Ecommerce\EcommerceBundle\Entity\Subcategory $subcategory
     */
    public function setSubcategory(\Ecommerce\EcommerceBundle\Entity\Subcategory $subcategory)
    {
        $this->subcategory = $subcategory;
    }

    /**
     * Get subcategory
     *
     * @return Ecommerce\EcommerceBundle\Entity\Subcategory 
     */
    public function getSubcategory()
    {
        return $this->subcategory;
    }

    /**
     * Set category
     *
     * @param Ecommerce\EcommerceBundle\Entity\Category $category
     */
    public function setCategory(\Ecommerce\EcommerceBundle\Entity\Category $category)
    {
        $this->category = $category;
    }

    /**
     * Get category
     *
     * @return Ecommerce\EcommerceBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }
}