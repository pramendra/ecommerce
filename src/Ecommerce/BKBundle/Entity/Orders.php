<?php

namespace Ecommerce\BKBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ecommerce\BKBundle\Entity\Orders
 */
class Orders
{
    /**
     * @var integer $id
     */
    protected $id;

    /**
     * @var string $ordernr
     */
    protected $ordernr;

    /**
     * @var integer $status
     */
    protected $status;

    /**
     * @var datetime $createdAt
     */
    protected $createdAt;

    /**
     * @var integer $payed
     */
    protected $payed;

    /**
     * @var float $total
     */
    protected $total;

    /**
     * @var string $shippingCode
     */
    protected $shippingCode;
    
    /**
     * @var datetime $shippingDate
     */
    protected $shippingDate;
    
    /**
     * @var Ecommerce\BKBundle\Entity\Paymethod
     */
    protected $paymethod;

    /**
     * @var Ecommerce\BKBundle\Entity\Coupon
     */
    protected $coupon;

    /**
     * @var Ecommerce\BKBundle\Entity\Client
     */
    protected $client;

    /**
     * @var Ecommerce\BKBundle\Entity\Shipping
     */
    protected $shipping;
    
    /**
     * @var Ecommerce\BKBundle\Entity\OrdersProducts
     */
    protected $products;


    public function __construct() {

        $this->products = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set ordernr
     *
     * @param string $ordernr
     */
    public function setOrdernr($ordernr)
    {
        $this->ordernr = $ordernr;
    }

    /**
     * Get ordernr
     *
     * @return string 
     */
    public function getOrdernr()
    {
        return $this->ordernr;
    }

    /**
     * Set status
     *
     * @param integer $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
    }
    
    /**
     * Set shippingCode
     *
     * @param text $shippingCode
     */
    public function setShippingCode($shippingCode)
    {
        $this->shippingCode = $shippingCode;
    }

    /**
     * Get shippingCode
     *
     * @return text 
     */
    public function getShippingCode()
    {
        return $this->shippingCode;
    }

    /**
     * Set createdAt
     *
     * @param datetime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Get createdAt
     *
     * @return datetime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set ShippingDate
     *
     * @param datetime $shippingDate
     */
    public function setShippingDate($shippingDate)
    {
        $this->shippingDate = $shippingDate;
    }

    /**
     * Get shippingDate
     *
     * @return datetime 
     */
    public function getShippingDate()
    {
        return $this->shippingDate;
    }

    /**
     * Set payed
     *
     * @param integer $payed
     */
    public function setPayed($payed)
    {
        $this->payed = $payed;
    }

    /**
     * Get payed
     *
     * @return integer 
     */
    public function getPayed()
    {
        return $this->payed;
    }

    /**
     * Set total
     *
     * @param float $total
     */
    public function setTotal($total)
    {
        $this->total = $total;
    }

    /**
     * Get total
     *
     * @return float 
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set paymethod
     *
     * @param Ecommerce\BKBundle\Entity\Paymethod $paymethod
     */
    public function setPaymethod(\Ecommerce\BKBundle\Entity\Paymethod $paymethod)
    {
        $this->paymethod = $paymethod;
    }

    /**
     * Get paymethod
     *
     * @return Ecommerce\BKBundle\Entity\Paymethod 
     */
    public function getPaymethod()
    {
        return $this->paymethod;
    }

    /**
     * Set coupon
     *
     * @param Ecommerce\BKBundle\Entity\Coupon $coupon
     */
    public function setCoupon(\Ecommerce\BKBundle\Entity\Coupon $coupon)
    {
        $this->coupon = $coupon;
    }

    /**
     * Get coupon
     *
     * @return Ecommerce\BKBundle\Entity\Coupon 
     */
    public function getCoupon()
    {
        return $this->coupon;
    }

    /**
     * Set client
     *
     * @param Ecommerce\BKBundle\Entity\Client $client
     */
    public function setClient(\Ecommerce\BKBundle\Entity\Client $client)
    {
        $this->client = $client;
    }

    /**
     * Get client
     *
     * @return Ecommerce\BKBundle\Entity\Client 
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set shipping
     *
     * @param Ecommerce\BKBundle\Entity\Shipping $shipping
     */
    public function setShipping(\Ecommerce\BKBundle\Entity\Shipping $shipping)
    {
        $this->shipping = $shipping;
    }

    /**
     * Get shipping
     *
     * @return Ecommerce\BKBundle\Entity\Shipping 
     */
    public function getShipping()
    {
        return $this->shipping;
    }
    
    
    /**
     * Add product
     *
     * @param Ecommerce\BKBundle\Entity\OrdersProduct $product
     */
    public function addProduct(\Ecommerce\BKBundle\Entity\OrdersProduct $product) {
        $product->setOrder($this);
        $this->products[] = $product;
    }

    /**
     * Set products
     *
     * @param Doctrine\Common\Collections\ArrayCollection $products
     */
    public function setProducts(\Doctrine\Common\Collections\ArrayCollection $products) {
        $this->products = $products;
    }

    /**
     * Get products
     *
     * @return Doctrine\Common\Collections\ArrayCollection
     */
    public function getProducts() {
        return $this->products;
    }
    
    function __toJson() {
        $json = new \stdClass();

        foreach ($this as $key => $value) {
            if (is_object($value)) {
                if (method_exists($value, '__toJson')) {
                    $json->$key = $value->__toJson();
                }
            } else {
                $json->$key = $value;
            }
        }
        return $json;
    }
}