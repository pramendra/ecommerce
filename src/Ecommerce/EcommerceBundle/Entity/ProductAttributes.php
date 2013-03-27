<?php

namespace Ecommerce\EcommerceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ecommerce\EcommerceBundle\Entity\ProductAttributes
 */
class ProductAttributes
{
    /**
     * @var integer $id
     */
    protected $id;

    /**
     * @var text $attributeValue
     */
    protected $attributeValue;

    /**
     * @var integer $isSelectable
     */
    protected $isSelectable;

    /**
     * @var Ecommerce\EcommerceBundle\Entity\Product
     */
    protected $product;

    /**
     * @var Ecommerce\EcommerceBundle\Entity\Attribute
     */
    protected $attribute;


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
     * Set attributeValue
     *
     * @param text $attributeValue
     */
    public function setAttributeValue($attributeValue)
    {
        $this->attributeValue = $attributeValue;
    }

    /**
     * Get attributeValue
     *
     * @return text 
     */
    public function getAttributeValue()
    {
        return $this->attributeValue;
    }

    /**
     * Set isSelectable
     *
     * @param integer $isSelectable
     */
    public function setIsSelectable($isSelectable)
    {
        $this->isSelectable = $isSelectable;
    }

    /**
     * Get isSelectable
     *
     * @return integer 
     */
    public function getIsSelectable()
    {
        return $this->isSelectable;
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

    /**
     * Set attribute
     *
     * @param Ecommerce\EcommerceBundle\Entity\Attribute $attribute
     */
    public function setAttribute(\Ecommerce\EcommerceBundle\Entity\Attribute $attribute)
    {
        $this->attribute = $attribute;
    }

    /**
     * Get attribute
     *
     * @return Ecommerce\EcommerceBundle\Entity\Attribute 
     */
    public function getAttribute()
    {
        return $this->attribute;
    }
}