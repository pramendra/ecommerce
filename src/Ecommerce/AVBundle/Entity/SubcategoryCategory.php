<?php

namespace Ecommerce\AVBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ecommerce\AVBundle\Entity\SubcategoryCategory
 */
class SubcategoryCategory
{
    /**
     * @var integer $id
     */
    protected $id;

    /**
     * @var Ecommerce\AVBundle\Entity\Subcategory
     */
    protected $subcategory;

    /**
     * @var Ecommerce\AVBundle\Entity\Category
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
     * @param Ecommerce\AVBundle\Entity\Subcategory $subcategory
     */
    public function setSubcategory(\Ecommerce\AVBundle\Entity\Subcategory $subcategory)
    {
        $this->subcategory = $subcategory;
    }

    /**
     * Get subcategory
     *
     * @return Ecommerce\AVBundle\Entity\Subcategory 
     */
    public function getSubcategory()
    {
        return $this->subcategory;
    }

    /**
     * Set category
     *
     * @param Ecommerce\AVBundle\Entity\Category $category
     */
    public function setCategory(\Ecommerce\AVBundle\Entity\Category $category)
    {
        $this->category = $category;
    }

    /**
     * Get category
     *
     * @return Ecommerce\AVBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }
}