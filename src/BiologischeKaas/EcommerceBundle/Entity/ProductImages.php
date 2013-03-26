<?php

namespace BiologischeKaas\EcommerceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BiologischeKaas\EcommerceBundle\Entity\ProductImages
 */
class ProductImages {

    /**
     * @var integer $id
     */
    protected $id;

    /**
     * @var string $name
     */
    protected $name;

    /**
     * @var string $path
     */
    protected $path;

    /**
     * @var integer $file_size
     */
    protected $fileSize;

    /**
     * @var string $thumbPath
     */
    protected $thumbPath;

    /**
     * @var datetime $createdAt
     */
    protected $createdAt;

    /**
     * @var BiologischeKaas\EcommerceBundle\Entity\Product
     */
    protected $product;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set path
     *
     * @param string $path
     */
    public function setPath($path) {
        $this->path = $path;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath() {
        return $this->path;
    }

    /**
     * Set fileSize
     *
     * @param integer $file_size
     */
    public function setFileSize($file_size) {
        $this->fileSize = $file_size;
    }

    /**
     * Get file_size
     *
     * @return integer 
     */
    public function getFileSize() {
        return $this->fileSize;
    }

    /**
     * Set thumbPath
     *
     * @param string $thumbPath
     */
    public function setThumbPath($thumbPath) {
        $this->thumbPath = $thumbPath;
    }

    /**
     * Get thumbPath
     *
     * @return string 
     */
    public function getThumbPath() {
        return $this->thumbPath;
    }

    /**
     * Set createdAt
     *
     * @param datetime $createdAt
     */
    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;
    }

    /**
     * Get createdAt
     *
     * @return datetime 
     */
    public function getCreatedAt() {
        return $this->createdAt;
    }

    /**
     * Set product
     *
     * @param BiologischeKaas\EcommerceBundle\Entity\Product $product
     */
    public function setProduct(\BiologischeKaas\EcommerceBundle\Entity\Product $product) {
        $this->product = $product;
    }

    /**
     * Get product
     *
     * @return BiologischeKaas\EcommerceBundle\Entity\Product 
     */
    public function getProduct() {
        return $this->product;
    }
    
    /**
     * 
     * @return string
     */
    public function __toString() {
        return $this->thumbPath;
    }

}