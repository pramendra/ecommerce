<?php

namespace BiologischeKaas\EcommerceBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * BiologischeKaas\EcommerceBundle\Entity\Client
 */
class Client implements UserInterface {

    /**
     * @var integer $id
     */
    protected $id;

    /**
     * @var string $name
     */
    protected $name;

    /**
     * @var string $address
     */
    protected $address;

    /**
     * @var string $housenumber
     */
    protected $housenumber;
    /**
     * @var string $zipcode
     */
    protected $zipcode;

    /**
     * @var string $location
     */
    protected $location;

    /**
     * @var string $country
     */
    protected $country;

    /**
     * @var string $phone
     */
    protected $phone;

    /**
     * @var string $email
     */
    protected $email;

    /**
     * @var string $password
     */
    protected $password;

    /**
     * @var string $algorithm
     */
    protected $algorithm;

    /**
     * @var string $salt
     */
    protected $salt;

    /**
     * @var string $shippingAddress
     */
    protected $shippingAddress;

    /**
     * @var string $shippingZipcode
     */
    protected $shippingZipcode;

    /**
     * @var string $shippingLocation
     */
    protected $shippingLocation;

    /**
     * @var string $shippingCountry
     */
    protected $shippingCountry;

    /**
     * @var string $ipAddress
     */
    protected $ipAddress;

    /**
     * @var text $reffer
     */
    protected $reffer;

    /**
     * @var integer $acceptNewsletter
     */
    protected $acceptNewsletter;

    /**
     * @var text $history
     */
    protected $history;

    /**
     * @var datetime $createdAt
     */
    protected $createdAt;

    /**
     * @var datetime $updatedAt
     */
    protected $updatedAt;

    /**
     * @var datetime $deletedAt
     */
    protected $deletedAt;

    /**
     * @var BiologischeKaas\EcommerceBundle\Entity\Orders
     */
    protected $orders;

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
     * Set address
     *
     * @param string $address
     */
    public function setAddress($address) {
        $this->address = $address;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress() {
        return $this->address;
    }

    /**
     * Set zipcode
     *
     * @param string $zipcode
     */
    public function setZipcode($zipcode) {
        $this->zipcode = $zipcode;
    }

    /**
     * Get zipcode
     *
     * @return string 
     */
    public function getZipcode() {
        return $this->zipcode;
    }

    /**
     * Set housenumber
     *
     * @param string $housenumber
     */
    public function setHousenumber($housenumber) {
        $this->housenumber = $housenumber;
    }

    /**
     * Get housenumber
     *
     * @return string 
     */
    public function getHousenumber() {
        return $this->housenumber;
    }

    /**
     * Set location
     *
     * @param string $location
     */
    public function setLocation($location) {
        $this->location = $location;
    }

    /**
     * Get location
     *
     * @return string 
     */
    public function getLocation() {
        return $this->location;
    }

    /**
     * Set country
     *
     * @param string $country
     */
    public function setCountry($country) {
        $this->country = $country;
    }

    /**
     * Get country
     *
     * @return string 
     */
    public function getCountry() {
        return $this->country;
    }

    /**
     * Set phone
     *
     * @param string $phone
     */
    public function setPhone($phone) {
        $this->phone = $phone;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone() {
        return $this->phone;
    }

    /**
     * Set email
     *
     * @param string $email
     */
    public function setEmail($email) {
        $this->email = $email;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password
     */
    public function setPassword($password) {
        $this->password = $password;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * Set algorithm
     *
     * @param string $algorithm
     */
    public function setAlgorithm($algorithm) {
        $this->algorithm = $algorithm;
    }

    /**
     * Get algorithm
     *
     * @return string
     */
    public function getAlgorithm() {
        return $this->algorithm;
    }

    /**
     * Set salt
     *
     * @param string $salt
     */
    public function setSalt($salt) {
        $this->salt = $salt;
    }

    /**
     * Get salt
     *
     * @return string
     */
    public function getSalt() {
        return $this->salt;
    }

    /**
     * Set shippingAddress
     *
     * @param string $shippingAddress
     */
    public function setShippingAddress($shippingAddress) {
        $this->shippingAddress = $shippingAddress;
    }

    /**
     * Get shippingAddress
     *
     * @return string 
     */
    public function getShippingAddress() {
        return $this->shippingAddress;
    }

    /**
     * Set shippingZipcode
     *
     * @param string $shippingZipcode
     */
    public function setShippingZipcode($shippingZipcode) {
        $this->shippingZipcode = $shippingZipcode;
    }

    /**
     * Get shippingZipcode
     *
     * @return string 
     */
    public function getShippingZipcode() {
        return $this->shippingZipcode;
    }

    /**
     * Set shippingLocation
     *
     * @param string $shippingLocation
     */
    public function setShippingLocation($shippingLocation) {
        $this->shippingLocation = $shippingLocation;
    }

    /**
     * Get shippingLocation
     *
     * @return string 
     */
    public function getShippingLocation() {
        return $this->shippingLocation;
    }

    /**
     * Set shippingCountry
     *
     * @param string $shippingCountry
     */
    public function setShippingCountry($shippingCountry) {
        $this->shippingCountry = $shippingCountry;
    }

    /**
     * Get shippingCountry
     *
     * @return string 
     */
    public function getShippingCountry() {
        return $this->shippingCountry;
    }

    /**
     * Set ipAddress
     *
     * @param string $ipAddress
     */
    public function setIpAddress($ipAddress) {
        $this->ipAddress = $ipAddress;
    }

    /**
     * Get ipAddress
     *
     * @return string 
     */
    public function getIpAddress() {
        return $this->ipAddress;
    }

    /**
     * Set reffer
     *
     * @param text $reffer
     */
    public function setReffer($reffer) {
        $this->reffer = $reffer;
    }

    /**
     * Get reffer
     *
     * @return text 
     */
    public function getReffer() {
        return $this->reffer;
    }

    /**
     * Set acceptNewsletter
     *
     * @param integer $acceptNewsletter
     */
    public function setAcceptNewsletter($acceptNewsletter) {
        $this->acceptNewsletter = $acceptNewsletter;
    }

    /**
     * Get acceptNewsletter
     *
     * @return integer 
     */
    public function getAcceptNewsletter() {
        return $this->acceptNewsletter;
    }

    /**
     * Set history
     *
     * @param text $history
     */
    public function setHistory($history) {
        $this->history = $history;
    }

    /**
     * Get history
     *
     * @return text 
     */
    public function getHistory() {
        return $this->history;
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
     * Set updatedAt
     *
     * @param datetime $updatedAt
     */
    public function setUpdatedAt($updatedAt) {
        $this->updatedAt = $updatedAt;
    }

    /**
     * Get updatedAt
     *
     * @return datetime 
     */
    public function getUpdatedAt() {
        return $this->updatedAt;
    }

    /**
     * Set deletedAt
     *
     * @param datetime $deletedAt
     */
    public function setDeletedAt($deletedAt) {
        $this->deletedAt = $deletedAt;
    }

    /**
     * Get deletedAt
     *
     * @return datetime 
     */
    public function getDeletedAt() {
        return $this->deletedAt;
    }

    /**
     * Add orders
     *
     * @param BiologischeKaas\EcommerceBundle\Entity\Orders $order
     */
    public function addOrders(\BiologischeKaas\EcommerceBundle\Entity\Orders $order) {
        $this->orders[] = $order;
    }

    /**
     * Set orders
     *
     * @param Doctrine\Common\Collections\ArrayCollection $orders
     */
    public function setOrders(\Doctrine\Common\Collections\ArrayCollection $orders) {
        $this->orders = $orders;
    }

    /**
     * Get orders
     *
     * @return Doctrine\Common\Collections\ArrayCollection
     */
    public function getOrders() {
        return $this->orders;
    }

    function getRoles() {
        $roles = array();

        $roles[] = 'ROLE_CLIENT';
        $roles[] = 'ROLE_CLIENT_ACTIVE';

        if($this->email == 'info@addictedtovintage.nl') { 
            $roles[] = 'ROLE_ADMIN';
        }
        
        return $roles;
    }

    function getUsername() {
        return $this->email;
    }

    function eraseCredentials() {
        
    }

    function equals(UserInterface $user) {
        return ($this->email == $user->getEmail()) && ($this->id == $user->getId());
    }

    function __toString() {
        if ($this->name == null) {
            return 'NULL';
        }
        return $this->name;
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