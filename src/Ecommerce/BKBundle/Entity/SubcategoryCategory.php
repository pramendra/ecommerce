<?php

namespace Ecommerce\BKBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ecommerce\BKBundle\Entity\SubcategoryCategory
 */
class SubcategoryCategory
{
    /**
     * @var integer $id
     */
    protected $id;

    /**
     * @var Ecommerce\BKBundle\Entity\Subcategory
     */
    protected $subcategory;

    /**
     * @var Ecommerce\BKBundle\Entity\Category
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
     * @param Ecommerce\BKBundle\Entity\Subcategory $subcategory
     */
    public function setSubcategory(\Ecommerce\BKBundle\Entity\Subcategory $subcategory)
    {
        $this->subcategory = $subcategory;
    }

    /**
     * Get subcategory
     *
     * @return Ecommerce\BKBundle\Entity\Subcategory 
     */
    public function getSubcategory()
    {
        return $this->subcategory;
    }

    /**
     * Set category
     *
     * @param Ecommerce\BKBundle\Entity\Category $category
     */
    public function setCategory(\Ecommerce\BKBundle\Entity\Category $category)
    {
        $this->category = $category;
    }

    /**
     * Get category
     *
     * @return Ecommerce\BKBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }
}