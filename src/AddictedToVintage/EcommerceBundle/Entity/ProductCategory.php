<?php

namespace AddictedToVintage\EcommerceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AddictedToVintage\EcommerceBundle\Entity\ProductCategory
 */
class ProductCategory
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
     * @var AddictedToVintage\EcommerceBundle\Entity\Product
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
     * Set product
     *
     * @param AddictedToVintage\EcommerceBundle\Entity\Product $product
     */
    public function setProduct(\AddictedToVintage\EcommerceBundle\Entity\Product $product)
    {
        $this->product = $product;
    }

    /**
     * Get product
     *
     * @return AddictedToVintage\EcommerceBundle\Entity\Product 
     */
    public function getProduct()
    {
        return $this->product;
    }
}