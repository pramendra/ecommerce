<?php

namespace Ecommerce\SGBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ecommerce\SGBundle\Entity\SubcategoryCategory
 */
class SubcategoryCategory
{
    /**
     * @var integer $id
     */
    protected $id;

    /**
     * @var Ecommerce\SGBundle\Entity\Subcategory
     */
    protected $subcategory;

    /**
     * @var Ecommerce\SGBundle\Entity\Category
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
     * @param Ecommerce\SGBundle\Entity\Subcategory $subcategory
     */
    public function setSubcategory(\Ecommerce\SGBundle\Entity\Subcategory $subcategory)
    {
        $this->subcategory = $subcategory;
    }

    /**
     * Get subcategory
     *
     * @return Ecommerce\SGBundle\Entity\Subcategory 
     */
    public function getSubcategory()
    {
        return $this->subcategory;
    }

    /**
     * Set category
     *
     * @param Ecommerce\SGBundle\Entity\Category $category
     */
    public function setCategory(\Ecommerce\SGBundle\Entity\Category $category)
    {
        $this->category = $category;
    }

    /**
     * Get category
     *
     * @return Ecommerce\SGBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }
}