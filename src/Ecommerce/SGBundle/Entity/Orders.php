<?php

namespace Ecommerce\SGBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ecommerce\SGBundle\Entity\Orders
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
     * @var Ecommerce\SGBundle\Entity\Paymethod
     */
    protected $paymethod;

    /**
     * @var Ecommerce\SGBundle\Entity\Coupon
     */
    protected $coupon;

    /**
     * @var Ecommerce\SGBundle\Entity\Client
     */
    protected $client;

    /**
     * @var Ecommerce\SGBundle\Entity\Shipping
     */
    protected $shipping;
    
    /**
     * @var Ecommerce\SGBundle\Entity\OrdersProducts
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
     * @param Ecommerce\SGBundle\Entity\Paymethod $paymethod
     */
    public function setPaymethod(\Ecommerce\SGBundle\Entity\Paymethod $paymethod)
    {
        $this->paymethod = $paymethod;
    }

    /**
     * Get paymethod
     *
     * @return Ecommerce\SGBundle\Entity\Paymethod 
     */
    public function getPaymethod()
    {
        return $this->paymethod;
    }

    /**
     * Set coupon
     *
     * @param Ecommerce\SGBundle\Entity\Coupon $coupon
     */
    public function setCoupon(\Ecommerce\SGBundle\Entity\Coupon $coupon)
    {
        $this->coupon = $coupon;
    }

    /**
     * Get coupon
     *
     * @return Ecommerce\SGBundle\Entity\Coupon 
     */
    public function getCoupon()
    {
        return $this->coupon;
    }

    /**
     * Set client
     *
     * @param Ecommerce\SGBundle\Entity\Client $client
     */
    public function setClient(\Ecommerce\SGBundle\Entity\Client $client)
    {
        $this->client = $client;
    }

    /**
     * Get client
     *
     * @return Ecommerce\SGBundle\Entity\Client 
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set shipping
     *
     * @param Ecommerce\SGBundle\Entity\Shipping $shipping
     */
    public function setShipping(\Ecommerce\SGBundle\Entity\Shipping $shipping)
    {
        $this->shipping = $shipping;
    }

    /**
     * Get shipping
     *
     * @return Ecommerce\SGBundle\Entity\Shipping 
     */
    public function getShipping()
    {
        return $this->shipping;
    }
    
    
    /**
     * Add product
     *
     * @param Ecommerce\SGBundle\Entity\OrdersProduct $product
     */
    public function addProduct(\Ecommerce\SGBundle\Entity\OrdersProduct $product) {
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