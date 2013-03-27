<?php

namespace Ecommerce\AVBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ecommerce\AVBundle\Entity\ProductCategory
 */
class ProductCategory
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
     * @var Ecommerce\AVBundle\Entity\Product
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
     * Set product
     *
     * @param Ecommerce\AVBundle\Entity\Product $product
     */
    public function setProduct(\Ecommerce\AVBundle\Entity\Product $product)
    {
        $this->product = $product;
    }

    /**
     * Get product
     *
     * @return Ecommerce\AVBundle\Entity\Product 
     */
    public function getProduct()
    {
        return $this->product;
    }
}