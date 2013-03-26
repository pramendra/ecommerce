<?php

namespace Ecommerce\BiologischekaasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ecommerce\BiologischekaasBundle\Entity\ProductCategory
 */
class ProductCategory
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
     * @var Ecommerce\BiologischekaasBundle\Entity\Product
     */
    protected $product;


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
     * Set product
     *
     * @param Ecommerce\BiologischekaasBundle\Entity\Product $product
     */
    public function setProduct(\Ecommerce\BiologischekaasBundle\Entity\Product $product)
    {
        $this->product = $product;
    }

    /**
     * Get product
     *
     * @return Ecommerce\BiologischekaasBundle\Entity\Product 
     */
    public function getProduct()
    {
        return $this->product;
    }
}