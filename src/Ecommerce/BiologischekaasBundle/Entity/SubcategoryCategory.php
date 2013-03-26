<?php

namespace Ecommerce\BiologischekaasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ecommerce\BiologischekaasBundle\Entity\SubcategoryCategory
 */
class SubcategoryCategory
{
    /**
     * @var integer $id
     */
    protected $id;

    /**
     * @var Ecommerce\BiologischekaasBundle\Entity\Subcategory
     */
    protected $subcategory;

    /**
     * @var Ecommerce\BiologischekaasBundle\Entity\Category
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
     * @param Ecommerce\BiologischekaasBundle\Entity\Subcategory $subcategory
     */
    public function setSubcategory(\Ecommerce\BiologischekaasBundle\Entity\Subcategory $subcategory)
    {
        $this->subcategory = $subcategory;
    }

    /**
     * Get subcategory
     *
     * @return Ecommerce\BiologischekaasBundle\Entity\Subcategory 
     */
    public function getSubcategory()
    {
        return $this->subcategory;
    }

    /**
     * Set category
     *
     * @param Ecommerce\BiologischekaasBundle\Entity\Category $category
     */
    public function setCategory(\Ecommerce\BiologischekaasBundle\Entity\Category $category)
    {
        $this->category = $category;
    }

    /**
     * Get category
     *
     * @return Ecommerce\BiologischekaasBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }
}