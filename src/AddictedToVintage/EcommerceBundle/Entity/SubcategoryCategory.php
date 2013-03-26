<?php

namespace AddictedToVintage\EcommerceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AddictedToVintage\EcommerceBundle\Entity\SubcategoryCategory
 */
class SubcategoryCategory
{
    /**
     * @var integer $id
     */
    protected $id;

    /**
     * @var AddictedToVintage\EcommerceBundle\Entity\Subcategory
     */
    protected $subcategory;

    /**
     * @var AddictedToVintage\EcommerceBundle\Entity\Category
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
     * @param AddictedToVintage\EcommerceBundle\Entity\Subcategory $subcategory
     */
    public function setSubcategory(\AddictedToVintage\EcommerceBundle\Entity\Subcategory $subcategory)
    {
        $this->subcategory = $subcategory;
    }

    /**
     * Get subcategory
     *
     * @return AddictedToVintage\EcommerceBundle\Entity\Subcategory 
     */
    public function getSubcategory()
    {
        return $this->subcategory;
    }

    /**
     * Set category
     *
     * @param AddictedToVintage\EcommerceBundle\Entity\Category $category
     */
    public function setCategory(\AddictedToVintage\EcommerceBundle\Entity\Category $category)
    {
        $this->category = $category;
    }

    /**
     * Get category
     *
     * @return AddictedToVintage\EcommerceBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }
}