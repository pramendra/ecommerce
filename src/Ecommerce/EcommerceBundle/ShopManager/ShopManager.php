<?php

namespace Ecommerce\EcommerceBundle\ShopManager;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Ecommerce\EcommerceBundle\Entity\Cart;
use Ecommerce\EcommerceBundle\Entity\CartProducts;
use Ecommerce\EcommerceBundle\Entity\Client;
use Ecommerce\EcommerceBundle\Entity\Product;
use Ecommerce\EcommerceBundle\Entity\Shipping;
use Ecommerce\EcommerceBundle\Entity\ShippingTypes;
use Ecommerce\EcommerceBundle\Entity\Orders;
use Ecommerce\EcommerceBundle\Entity\OrdersProduct;
use Ecommerce\EcommerceBundle\Entity\Coupon;
use Ecommerce\EcommerceBundle\Entity\Paymethod;

class ShopManager extends ContainerAware {

    private $session;
    private $request;
    private $cart;
    private $client;
    private $shipping;
    private $shipping_date;
    private $paymethod;
    private $order;
    private $logger;
    private $products;
    private $coupon;
    private $discount;
    private $sale_discount;
    private $shoppingList;
    public $use_debug;

    function __construct() {

        $this->logger = array();
        $this->use_debug = false;
        
    }

    function initialize() {

        $this->request = $this->getRequest();
        $this->session = $this->request->getSession();
        $this->shoppingList = $this->getRequest()->cookies->get('ADTV_SHOPPING_LIST');
        
        $this->sale_discount = $this->container->getParameter('sale_discount');

        if ($this->session->get('client') !== null) {
            $this->client = $this->session->get('client');
        } else {
            $this->client = null;
            $this->session->set('client', $this->client);
        }

        if ($this->session->get('products') !== null) {
            $this->products = $this->session->get('products');
        } else {
            $this->products = array();
            $this->session->set('products', $this->products);
        }

        if ($this->session->get('paymethod') !== null) {
            $this->paymethod = $this->session->get('paymethod');
        } else {
            $this->paymethod = null;
            $this->session->set('paymethod', $this->paymethod);
        }

        if ($this->session->get('cart') !== null) {
            $cart = $this->session->get('cart');
            
            if($cart->getId() !== null) {
                $this->cart = $this->getDoctrine()->getRepository('EcommerceBundle:Cart')->find($cart->getId());
            } else { 
                $this->cart = new Cart();
                $this->session->set('cart', $this->cart);
            }
            
        } else {
            $this->cart = new Cart();
            $this->session->set('cart', $this->cart);
        }

        if ($this->session->get('order') !== null) {
            $order = $this->session->get('order');
            $this->order = $this->getDoctrine()->getRepository('EcommerceBundle:Orders')->find($order->getId());
        } else {
            $this->order = null;
            $this->session->set('order', $this->order);
        }

        if ($this->session->get('shipping') !== null) {
            $this->shipping = $this->session->get('shipping');
        } else {
            $this->shipping = $this->getDoctrine()->getRepository('EcommerceBundle:Shipping')->find(1);
            $this->session->set('shipping', $this->shipping);
        }

        if ($this->session->get('shipping_date') !== null) {
            $this->shipping_date = $this->session->get('shipping_date');
        } else {
            $this->shipping_date = null;
            $this->session->set('shipping', $this->shipping_date);
        }

        if ($this->session->get('coupon') !== null) {
            $this->coupon = $this->session->get('coupon');
        } else {
            $this->coupon = new Coupon();
            $this->session->set('coupon', $this->coupon);
        }
    }

    public function setDebugMode($mode) {
        return $this->use_debug = $mode;
    }

    public function setShipping($shipping) {
        
        $this->shipping = $this->getDoctrine()->getRepository('EcommerceBundle:Shipping')->find($shipping);
        $this->session->set('shipping', $this->shipping);        
        
        $this->cart->setShipping($this->shipping);
        
        $this->updateCart();
    }

    public function getCart() {
        return $this->cart;
    }

    public function getShoppingList() {

        $products = array();

        $list = \explode(',', $this->shoppingList);

        foreach ($list as $item) {

            if (!empty($item)) {

                $product = $this->getDoctrine()->getRepository('EcommerceBundle:Product')->find($item);
                $products[] = $product->__toJson();
            }
        }

        return $products;
    }

    public function addToShoppingList(Product $product) {

        $list = '';

        if (!empty($this->shoppingList)) {
            $list .= $this->shoppingList;
        }

        $list .= $product->getId() . ',';


        $cookie = new Cookie('ADTV_SHOPPING_LIST', $list, (time() + 3600 * 24 * 7), '/');

        $response = new Response();
        $response->headers->setCookie($cookie);
        $response->send();

        $this->shoppingList = $list;

        return $this->shoppingList;
    }

    public function getDiscount() {

        // Check couponcode        
        if ($this->coupon !== null) {

            switch ($this->coupon->getDiscountType()) {

                case "1" : // percentage
                    $this->discount = ($this->cart->getTotalPriceInc() / 100 * $this->coupon->getDiscount());
                    break;

                case "2" : // amount
                    $this->discount = $this->coupon->getDiscount();
                    break;
            }
        }


        return $this->discount;
    }

    public function getCoupon() {

        if ($this->coupon->getId() !== null) {
            return $this->getDoctrine()->getRepository('EcommerceBundle:Coupon')->find($this->coupon->getId());
        } else { 
            return null;
        }

    }

    public function getDebug() {

        $output = new \stdClass();

        foreach ($this->logger as $key => $val) {
            $output->$key = $val;
        }

        return $output;
    }

    public function getClient() {
        return $this->client;
    }

    public function setClient(Client $client) {
        $this->client = $client;
        $this->session->set('client', $this->client);
    }

    public function getOrder() {

        if ($this->session->get('order') !== null) {
            $order = $this->session->get('order');
            $this->order = $this->getDoctrine()->getRepository('EcommerceBundle:Orders')->find($order->getId());
        } else {
            $this->order = null;
        }

        return $this->order;
    }
    
    public function removeProductFromCart(Product $product) { 
        
        $em = $this->getDoctrine()->getEntityManager();

        $this->logger[] = 'Searching for shopping cart...';

        $this->cart = $this->getDoctrine()
                ->getRepository('EcommerceBundle:Cart')
                ->findOneBy(array('id' => $this->cart->getId()));

        $this->logger[] = 'Found existing shopping cart: ' . $this->cart->getId();

        $this->products[] = $product;

        $cartProduct = $this->getDoctrine()
                ->getRepository('EcommerceBundle:CartProducts')
                ->findOneBy(array('product' => $product->getId(), 'cart' => $this->cart->getId()));

        $em->remove($cartProduct);
        
        $this->logger[] = 'Removed ' . $product->getName() . ' from the shopping cart: ' . $this->cart->getId();
        
        $new_products = array();
        
        foreach ($this->products as $cart_product) {
         
            if($cart_product->getId() != $cartProduct->getId()) {
                $new_products[] = $cart_product;
            }
        }
        
        $this->products = $new_products;

        $containsPackage = false;

        foreach ($this->products as $cart_product) {
            
            if($cart_product->getShippingType()->getId() == 1 && $containsPackage == false) {
                $containsPackage = true;
            }
        }

        if ($containsPackage) {
            /* Fetch active shipping methods */
            $shipping = $this->getDoctrine()
                            ->getRepository('EcommerceBundle:Shipping')->findOneBy(array('shippingType' => 1, 'active' => 1));
            
        } else {
            /* Fetch active shipping methods */
            $shipping = $this->getDoctrine()
                            ->getRepository('EcommerceBundle:Shipping')->findOneBy(array('shippingType' => 2, 'active' => 1));
        }

        $this->cart->setShipping($shipping);

        $this->shipping = $shipping;
        
        $this->session->set('cart', $this->cart);
        $this->session->set('shipping', $this->shipping);

        $em->flush();
        
        $this->updateCart();
        
    }

    public function addProductToCart(Product $product, $amount, $arguments = array()) {

        $em = $this->getDoctrine()->getEntityManager();

        $this->logger[] = 'Searching for shopping cart...';

        if ($this->cart->getId() == null) {

            $this->createCart();

            $this->logger[] = 'Created shopping cart: ' . $this->cart->getId();
        } else {
            
            $this->cart = $this->getDoctrine()
                    ->getRepository('EcommerceBundle:Cart')
                    ->findOneBy(array('id' => $this->cart->getId()));

            $this->logger[] = 'Found existing shopping cart: ' . $this->cart->getId();
        }

        $this->products[] = $product;

        $cartProducts = $this->getDoctrine()
                ->getRepository('EcommerceBundle:CartProducts')
                ->findOneBy(array('product' => $product->getId(), 'cart' => $this->cart->getId()));

        if (count($cartProducts) == 0) {

            $cartProducts = new CartProducts();
            $cartProducts->setAmount($amount);
        } else {

            
            $amount = ($cartProducts->getAmount() + $amount);
            
            if($amount <= $product->getStock()) { 
                $cartProducts->setAmount($amount);
                $cartProducts->setUpdatedAt(new \DateTime('now'));
            } else { 
                return 'OUT_OF_STOCK';
            }
        }

        $cartProducts->setProduct($product);
        
        if($product->getIsSale() == 1) { 
            
            $price = $product->getPrice() - ($product->getPrice() / 100 * $this->sale_discount);
            
            $cartProducts->setPrice($price);
        } else { 
            $cartProducts->setPrice($product->getPrice());
        }
        
        
        $cartProducts->setCreatedAt(new \DateTime('now'));


        $this->logger[] = 'Added ' . $amount . ' x ' . $product->getName() . ' to the shopping cart: ' . $this->cart->getId();

        $this->logger[] = ' ' . count($this->cart->getProducts()) . ' products in the shopping cart: ' . $this->cart->getId();

        $this->cart->addProduct($cartProducts);
        
        $em->flush();

        $containsPackage = false;
        
        $this->logger[] = count($this->cart->getProducts());
        
        foreach ($this->cart->getProducts() as $cart_product) {
            
            if($cart_product->getProduct()->getShippingType()->getId() == 1 && $containsPackage == false) {
                $containsPackage = true;
            }
        }

        if ($containsPackage) {
            /* Fetch active shipping methods */
            $shipping = $this->getDoctrine()
                            ->getRepository('EcommerceBundle:Shipping')->findOneBy(array('shippingType' => 1, 'active' => 1));
            
        } else {
            /* Fetch active shipping methods */
            $shipping = $this->getDoctrine()
                            ->getRepository('EcommerceBundle:Shipping')->findOneBy(array('shippingType' => 2, 'active' => 1));
        }

        $this->cart->setShipping($shipping);

        $this->shipping = $shipping;

        $em->flush();
        
        $this->updateCart();

    }

    public function addCouponCode($code) {

        $this->coupon = $this->getDoctrine()->getRepository('EcommerceBundle:Coupon')->findOneBy(array('code' => $code));


        if ($this->coupon !== null) {

            // Attach coupon
            $this->cart->setCoupon($this->coupon);

            $this->session->set('coupon', $this->coupon);

            $this->updateCart();

            return true;
        } else {

            $this->session->set('coupon', null);

            $this->updateCart();

            return false;
        }
    }

    public function clearCouponCode() {
        $this->session->set('coupon', null);
        $this->updateCart();
        return true;
    }
    
    public function setPaymethod($request) { 
        
        $payment = $request->get('payment');
        
        $paymethod = $this->getDoctrine()->getRepository('EcommerceBundle:Paymethod')->findOneBy(array('code' => $payment[0]));
        
        $this->paymethod = $paymethod;
        
        $this->session->set('paymethod', $this->paymethod);
    }
    
    public function getPaymethod() { 
        
        return $this->paymethod;
    }

    public function createOrder($request) {

        // get entity manager
        $em = $this->getDoctrine()->getEntityManager();
        $this->client = $this->getDoctrine()->getRepository('EcommerceBundle:Client')->find($this->client->getId());
        $this->shipping = $this->getDoctrine()->getRepository('EcommerceBundle:Shipping')->find($this->shipping->getId());
        $this->paymethod = $this->getDoctrine()->getRepository('EcommerceBundle:Paymethod')->find($this->paymethod->getId());

        if ($this->shipping == null) {
            $this->shipping = $this->getDoctrine()->getRepository('EcommerceBundle:Shipping')->find(1);
        }

        if ($this->order == null) {

            // Create new order
            $this->order = new Orders();

            // Order information
            $this->order->setClient($this->client);
            $this->order->setPayed(false);
            $this->order->setPaymethod($this->paymethod);
            $this->order->setCreatedAt(new \DateTime());
            $this->order->setShipping($this->shipping);
            $this->order->setStatus('Wachten op betaling [BMSP]');
            
            $this->order->setShippingDate($this->shipping_date);
            
            if($this->coupon->getId() != null) { 
                
                $coupon = $this->getDoctrine()->getRepository('EcommerceBundle:Coupon')->find($this->coupon->getId());
                
                $this->order->setCoupon($coupon);
            }

            $totalPrice = ($this->shipping->getCosts() + $this->cart->getTotalPriceInc());

            $this->order->setTotal(number_format($totalPrice, 2, '.', '.'));

            // Fetch new orderNr
            $orderNr = $this->getDoctrine()->getRepository('EcommerceBundle:Orders')->getNewOrderNr();

            $this->order->setOrderNr($orderNr);

            $em->persist($this->order);
            $em->flush();

            $this->session->set('order', $this->order);

            // Add products to the order
            foreach ($this->cart->getProducts() as $cart_product) {

                // Create new OrderProduct
                $order_product = new OrdersProduct();
                $order_product->setProduct($cart_product->getProduct());
                $order_product->setAmount($cart_product->getAmount());
                $order_product->setPrice($cart_product->getPrice());
                $order_product->setTotalPrice($cart_product->getPrice() * $cart_product->getAmount());
                $order_product->setProductHistory(\serialize($cart_product->getProduct()->__toJson()));

                $order_product->setOrder($this->order);
                
                $product = $cart_product->getProduct();
                $product->setStock($product->getStock() - 1);

                $em->persist($order_product);
                $em->flush();

                $this->order->addProduct($order_product);
            }
        }

        $em->clear();
        $this->session->set('order', $this->order);
    }
    
    public function setClientShipping($request) { 

        // get entity manager
        $em = $this->getDoctrine()->getEntityManager();
        
        // no different shipping 
       $this->client->setShippingAddress($request->get('client_address') . ' ' . $request->get('client_housenumber'));
       $this->client->setShippingCountry($request->get('client_country'));
       $this->client->setShippingLocation($request->get('client_location'));
       $this->client->setShippingZipcode($request->get('client_zipcode'));
       
       $this->session->set('client', $this->client);
       
       $shippingDate = new \DateTime($request->get('shipping_date'));
       
       $this->shipping_date = $shippingDate;
       $this->session->set('shipping_date', $this->shipping_date);
       
       $em->flush();
        
    }
    
    public function getShippingDate() { 
        return $this->shipping_date;
    }
    
    public function createClient($request) {

        // get entity manager
        $em = $this->getDoctrine()->getEntityManager();

        if ($this->client == null) {

            // Create new client
            $this->client = new Client();

            // Basic  information
            $this->client->setAddress($request->get('client_address'));
            $this->client->setHousenumber($request->get('client_housenumber'));
            $this->client->setCountry($request->get('client_country'));
            $this->client->setEmail($request->get('client_email'));
            $this->client->setLocation($request->get('client_location'));
            $this->client->setName($request->get('client_name'));
            $this->client->setPhone($request->get('client_phone'));
            $this->client->setZipcode($request->get('client_zipcode'));

            $shipping_address = $request->get('client_shipping_address');

            if (!empty($shipping_address)) {

                // Shipping 
                $this->client->setShippingAddress($request->get('client_shipping_address'));
                $this->client->setShippingCountry($request->get('client_shipping_country'));
                $this->client->setShippingLocation($request->get('client_shipping_location'));
                $this->client->setShippingZipcode($request->get('client_shipping_zipcode'));
            } else {

                // no different shipping 
                $this->client->setShippingAddress($request->get('client_address'));
                $this->client->setShippingCountry($request->get('client_country'));
                $this->client->setShippingLocation($request->get('client_location'));
                $this->client->setShippingZipcode($request->get('client_zipcode'));
            }

            $newsletter = $request->get('client_newsletter');

            // Newsletter 
            if (!empty($newsletter)) {
                $this->client->setAcceptNewsletter($request->get('client_newsletter'));
            } else {
                $this->client->setAcceptNewsletter(null);
            }

            // Extra parameters
            $this->client->setipAddress($_SERVER['REMOTE_ADDR']);
            $this->client->setCreatedAt(new \DateTime());
            $this->client->setReffer(null);
            $this->client->setPassword('test');
            $this->client->setAlgorithm('sha1');
            $this->client->setSalt('sha1');

            // Set history
            $this->client->setHistory(\serialize($this->client->__toJson()));

            $em->persist($this->client);
            $em->flush();
        }

        $this->session->set('client', $this->client);
        
        $this->client = $this->getDoctrine()->getRepository('EcommerceBundle:Client')->find($this->client->getId());
        
        return $this->client;
    }

    private function createCart() {

        $sessionId = session_id();

        $this->cart = new Cart();

        $this->shipping = $this->getDoctrine()
                ->getRepository('EcommerceBundle:Shipping')
                ->findOneBy(array('id' => '1')); // Standaard PostNL

        $this->cart->setTotalPriceInc(0);
        $this->cart->setTotalPriceEx(0);
        $this->cart->setNumProducts(0);
        $this->cart->setSessionId($sessionId);
        $this->cart->setShipping($this->shipping);
        $this->cart->setUpdatedAt(null);
        $this->cart->setCreatedAt(new \DateTime('now'));

        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($this->cart);
        $em->flush();

        $this->session->set('cart', $this->cart);
    }

    private function updateCart() {

        $em = $this->getDoctrine()->getEntityManager();

        $cart = $this->getDoctrine()->getRepository('EcommerceBundle:Cart')->findOneBy(array('id' => $this->cart->getId()));
        
        if(count($cart->getProducts()) == 0) { 
            
            $this->clear();
            
            $em->remove($cart);
            
            $cart = null;
            $this->session->set('cart', $cart);
            
        } else { 

            $totalPriceInc = 0;
            $numProducts = 0;

            foreach ($cart->getProducts() as $cart_product) {

                $numProducts = ($numProducts + $cart_product->getAmount());
                $totalPriceInc = ($totalPriceInc + ( $cart_product->getPrice() * $cart_product->getAmount() ) );
            }

            $totalPriceInc = (($totalPriceInc - $this->getDiscount()));
            $totalPriceEx = ($totalPriceInc - ($totalPriceInc / 100 * 19));

            $cart->setTotalPriceInc($totalPriceInc);
            $cart->setTotalPriceEx($totalPriceEx);
            $cart->setNumProducts($numProducts);
            $cart->setUpdatedAt(new \DateTime);

        }
        
        $em->flush();

        $this->session->set('cart', $cart);
    }

    public function clear() {
        $this->session->clear();
    }

    /*     * ******** Shortcuts to the service container etc. ********* */

    /**
     * Shortcut to return the Doctrine Registry service.
     *
     * @return Registry
     *
     * @throws \LogicException If DoctrineBundle is not available
     */
    private function getDoctrine() {
        if (!$this->container->has('doctrine')) {
            throw new \LogicException('The DoctrineBundle is not installed in your application.');
        }

        return $this->container->get('doctrine');
    }

    /**
     * Shortcut to return the request service.
     *
     * @return Request
     */
    private function getRequest() {
        return $this->container->get('request');
    }

}

?>
