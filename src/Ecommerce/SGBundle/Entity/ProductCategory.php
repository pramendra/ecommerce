<?php

namespace Ecommerce\SGBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ecommerce\SGBundle\Entity\ProductCategory
 */
class ProductCategory
{
    /**
     * @var integer $id
     */
    protected $id;

    /**
     * @var Ecommerce\SGBundle\Entity\Subcategory
     */
    protected $subcategory;

    /**
     * @var Ecommerce\SGBundle\Entity\Product
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
     * @param Ecommerce\SGBundle\Entity\Subcategory $subcategory
     */
    public function setSubcategory(\Ecommerce\SGBundle\Entity\Subcategory $subcategory)
    {
        $this->subcategory = $subcategory;
    }

    /**
     * Get subcategory
     *
     * @return Ecommerce\SGBundle\Entity\Subcategory 
     */
    public function getSubcategory()
    {
        return $this->subcategory;
    }

    /**
     * Set product
     *
     * @param Ecommerce\SGBundle\Entity\Product $product
     */
    public function setProduct(\Ecommerce\SGBundle\Entity\Product $product)
    {
        $this->product = $product;
    }

    /**
     * Get product
     *
     * @return Ecommerce\SGBundle\Entity\Product 
     */
    public function getProduct()
    {
        return $this->product;
    }
}