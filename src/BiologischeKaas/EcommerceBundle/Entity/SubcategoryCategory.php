<?php

namespace BiologischeKaas\EcommerceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BiologischeKaas\EcommerceBundle\Entity\SubcategoryCategory
 */
class SubcategoryCategory
{
    /**
     * @var integer $id
     */
    protected $id;

    /**
     * @var BiologischeKaas\EcommerceBundle\Entity\Subcategory
     */
    protected $subcategory;

    /**
     * @var BiologischeKaas\EcommerceBundle\Entity\Category
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
     * @param BiologischeKaas\EcommerceBundle\Entity\Subcategory $subcategory
     */
    public function setSubcategory(\BiologischeKaas\EcommerceBundle\Entity\Subcategory $subcategory)
    {
        $this->subcategory = $subcategory;
    }

    /**
     * Get subcategory
     *
     * @return BiologischeKaas\EcommerceBundle\Entity\Subcategory 
     */
    public function getSubcategory()
    {
        return $this->subcategory;
    }

    /**
     * Set category
     *
     * @param BiologischeKaas\EcommerceBundle\Entity\Category $category
     */
    public function setCategory(\BiologischeKaas\EcommerceBundle\Entity\Category $category)
    {
        $this->category = $category;
    }

    /**
     * Get category
     *
     * @return BiologischeKaas\EcommerceBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }
}