<?php

namespace BiologischeKaas\EcommerceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BiologischeKaas\EcommerceBundle\Entity\ProductCategory
 */
class ProductCategory
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
     * @var BiologischeKaas\EcommerceBundle\Entity\Product
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
     * Set product
     *
     * @param BiologischeKaas\EcommerceBundle\Entity\Product $product
     */
    public function setProduct(\BiologischeKaas\EcommerceBundle\Entity\Product $product)
    {
        $this->product = $product;
    }

    /**
     * Get product
     *
     * @return BiologischeKaas\EcommerceBundle\Entity\Product 
     */
    public function getProduct()
    {
        return $this->product;
    }
}