<?php

namespace BiologischeKaas\EcommerceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BiologischeKaas\EcommerceBundle\Entity\ProductAttributes
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
     * @var BiologischeKaas\EcommerceBundle\Entity\Product
     */
    protected $product;

    /**
     * @var BiologischeKaas\EcommerceBundle\Entity\Attribute
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

    /**
     * Set attribute
     *
     * @param BiologischeKaas\EcommerceBundle\Entity\Attribute $attribute
     */
    public function setAttribute(\BiologischeKaas\EcommerceBundle\Entity\Attribute $attribute)
    {
        $this->attribute = $attribute;
    }

    /**
     * Get attribute
     *
     * @return BiologischeKaas\EcommerceBundle\Entity\Attribute 
     */
    public function getAttribute()
    {
        return $this->attribute;
    }
}