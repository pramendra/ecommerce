<?php

namespace Ecommerce\AVBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ecommerce\AVBundle\Entity\ProductAttributes
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
     * @var Ecommerce\AVBundle\Entity\Product
     */
    protected $product;

    /**
     * @var Ecommerce\AVBundle\Entity\Attribute
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

    /**
     * Set attribute
     *
     * @param Ecommerce\AVBundle\Entity\Attribute $attribute
     */
    public function setAttribute(\Ecommerce\AVBundle\Entity\Attribute $attribute)
    {
        $this->attribute = $attribute;
    }

    /**
     * Get attribute
     *
     * @return Ecommerce\AVBundle\Entity\Attribute 
     */
    public function getAttribute()
    {
        return $this->attribute;
    }
}