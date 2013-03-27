<?php

namespace Ecommerce\AVBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ecommerce\AVBundle\Entity\Subcategory
 */
class Subcategory
{
    /**
     * @var integer $id
     */
    protected $id;

    /**
     * @var string $name
     */
    protected $name;

    /**
     * @var text $description
     */
    protected $description;

    /**
     * @var string $keywords
     */
    protected $keywords;

    /**
     * @var string $image
     */
    protected $image;

    /**
     * @var string $permalink
     */
    protected $permalink;

    /**
     * @var string $product_count
     */
    protected $product_count;

    /**
     * @var integer $active
     */
    protected $active;
    
    /*
     * @var Ecommerce\AVBundle\Entity\Product $products
     */
    protected $products;
    
    /*
     * @var Ecommerce\AVBundle\Entity\Category $categories
     */
    protected $categories;    
    
    
    public function __construct() { 
            
        $this->products = new \Doctrine\Common\Collections\ArrayCollection();
        $this->categories = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param text $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get description
     *
     * @return text 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set keywords
     *
     * @param string $keywords
     */
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;
    }

    /**
     * Get keywords
     *
     * @return string 
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * Set image
     *
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set permalink
     *
     * @param string $permalink
     */
    public function setPermalink($permalink)
    {
        $this->permalink = $permalink;
    }

    /**
     * Get permalink
     *
     * @return string 
     */
    public function getPermalink()
    {
        return $this->permalink;
    }

    /**
     * Set product_count
     *
     * @param string $product_count
     */
    public function setProductCount($product_count)
    {
        $this->product_count = $product_count;
    }

    /**
     * Get product_count
     *
     * @return string 
     */
    public function getProductCount()
    {
        
        $this->product_count = 0; 
        
        foreach($this->products as $product) { 
            if($product->getDeletedAt() == null && $product->getStock() > 0 && $product->getActive() == 1) { 
                $this->product_count++;
            }
        }
        
        return $this->product_count;
    }

    /**
     * Set active
     *
     * @param integer $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * Get active
     *
     * @return integer 
     */
    public function getActive()
    {
        return $this->active;
    }
    

    /**
     * Set products
     *
     * @param Doctrine\Common\Collections\ArrayCollection $products
     */
    public function setProducts($products)
    {
        $this->products = $products;
    }

    /**
     * Get products
     *
     * @return Doctrine\Common\Collections\ArrayCollection $products
     */
    public function getProducts()
    {
        return $this->products;
    }    
    

    /**
     * Set categories
     *
     * @param Doctrine\Common\Collections\ArrayCollection $categories
     */
    public function setCategories($categories)
    {
        $this->categories = $categories;
    }

    /**
     * Get categories
     *
     * @return Doctrine\Common\Collections\ArrayCollection $categories
     */
    public function getCategories()
    {
        return $this->categories;
    }    
    
    public function __toString() 
    {
        return $this->name;
    }
    
}