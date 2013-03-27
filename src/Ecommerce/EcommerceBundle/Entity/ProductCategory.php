<?php

namespace Ecommerce\EcommerceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ecommerce\EcommerceBundle\Entity\ProductCategory
 */
class ProductCategory
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
     * @var Ecommerce\EcommerceBundle\Entity\Product
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
     * Set product
     *
     * @param Ecommerce\EcommerceBundle\Entity\Product $product
     */
    public function setProduct(\Ecommerce\EcommerceBundle\Entity\Product $product)
    {
        $this->product = $product;
    }

    /**
     * Get product
     *
     * @return Ecommerce\EcommerceBundle\Entity\Product 
     */
    public function getProduct()
    {
        return $this->product;
    }
}