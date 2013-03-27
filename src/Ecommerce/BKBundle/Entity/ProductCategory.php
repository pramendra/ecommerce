<?php

namespace Ecommerce\BKBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ecommerce\BKBundle\Entity\ProductCategory
 */
class ProductCategory
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
     * @var Ecommerce\BKBundle\Entity\Product
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
     * Set product
     *
     * @param Ecommerce\BKBundle\Entity\Product $product
     */
    public function setProduct(\Ecommerce\BKBundle\Entity\Product $product)
    {
        $this->product = $product;
    }

    /**
     * Get product
     *
     * @return Ecommerce\BKBundle\Entity\Product 
     */
    public function getProduct()
    {
        return $this->product;
    }
}