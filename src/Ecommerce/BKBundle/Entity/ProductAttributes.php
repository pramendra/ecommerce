<?php

namespace Ecommerce\BKBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ecommerce\BKBundle\Entity\ProductAttributes
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
     * @var Ecommerce\BKBundle\Entity\Product
     */
    protected $product;

    /**
     * @var Ecommerce\BKBundle\Entity\Attribute
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

    /**
     * Set attribute
     *
     * @param Ecommerce\BKBundle\Entity\Attribute $attribute
     */
    public function setAttribute(\Ecommerce\BKBundle\Entity\Attribute $attribute)
    {
        $this->attribute = $attribute;
    }

    /**
     * Get attribute
     *
     * @return Ecommerce\BKBundle\Entity\Attribute 
     */
    public function getAttribute()
    {
        return $this->attribute;
    }
}