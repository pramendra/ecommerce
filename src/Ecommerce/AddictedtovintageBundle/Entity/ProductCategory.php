<?php

namespace Ecommerce\AddictedtovintageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ecommerce\AddictedtovintageBundle\Entity\ProductCategory
 */
class ProductCategory
{
    /**
     * @var integer $id
     */
    protected $id;

    /**
     * @var Ecommerce\AddictedtovintageBundle\Entity\Subcategory
     */
    protected $subcategory;

    /**
     * @var Ecommerce\AddictedtovintageBundle\Entity\Product
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
     * @param Ecommerce\AddictedtovintageBundle\Entity\Subcategory $subcategory
     */
    public function setSubcategory(\Ecommerce\AddictedtovintageBundle\Entity\Subcategory $subcategory)
    {
        $this->subcategory = $subcategory;
    }

    /**
     * Get subcategory
     *
     * @return Ecommerce\AddictedtovintageBundle\Entity\Subcategory 
     */
    public function getSubcategory()
    {
        return $this->subcategory;
    }

    /**
     * Set product
     *
     * @param Ecommerce\AddictedtovintageBundle\Entity\Product $product
     */
    public function setProduct(\Ecommerce\AddictedtovintageBundle\Entity\Product $product)
    {
        $this->product = $product;
    }

    /**
     * Get product
     *
     * @return Ecommerce\AddictedtovintageBundle\Entity\Product 
     */
    public function getProduct()
    {
        return $this->product;
    }
}