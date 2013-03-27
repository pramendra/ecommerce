<?php

namespace Ecommerce\AVBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AVBundle\Entity\Product;
use Ecommerce\AVBundle\MultiSafePay\MultiSafePay;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

define('BASE_URL_AV_AV', 'http://www.addictedtovintage.nl');

class CartController extends Controller {

    public function MSPPaymentPageAction() {

        $test = false;

        if ($this->getRequest()->get('test')) {
            $test = true;
        }

        return $this->render('AVBundle:MSP:betalen.html.twig', array('test' => $test));
    }

    public function indexAction() {

        $shopManager = $this->get('ShopManager');

        /* Fetch shopping cart */
        $cart = $shopManager->getCart();

        if ($cart == null) {

            $shopManager->clear();

            return new RedirectResponse($this->generateUrl('_root'));
        }
        
        /* Fetch discount */
        $discount = $shopManager->getDiscount();

        if (empty($discount)) {
            $discount = '0,00';
        } else {
            $discount = number_format($discount, 2, ',', '.');
        }
        
        $coupon = $shopManager->getCoupon();

        if($cart->getId() == null) { 
            $shippingType = 1;
            $cart = null;
        } else { 
            $shippingType = $cart->getShipping()->getShippingType()->getId();
        }
        
        /* Fetch active shipping methods */
        $shippings = $this->getDoctrine()->getRepository('AVBundle:Shipping')->findBy(array('shippingType' => $shippingType, 'active' => 1));
        
        return $this->render('AVBundle:Cart:index.html.twig', array('cart' => $cart, 'discount' => $discount, 'shippings' => $shippings, 'coupon' => $coupon));
    }

    public function shippingAction() {

        $shopManager = $this->get('ShopManager');

        /* Fetch shopping cart */
        $cart = $shopManager->getCart();

        if ($cart->getId() == null) {

            $shopManager->clear();

            return new RedirectResponse($this->generateUrl('_cart'));
        }

        /* Create client */
        if($this->getRequest()->getMethod() == 'POST') { 
            $client = $shopManager->createClient($this->getRequest());
        }
        
        /* Fetch active shipping methods */
        $shippings = $this->getDoctrine()->getRepository('AVBundle:Shipping')->findBy(array('shippingType' => $cart->getShipping()->getShippingType(), 'active' => 1));

        $next_delivery_date = $this->getNextDeliveryDate();
        
        $next_delivery_date_range = $this->getNextDeliveryDateRange();
        
        return $this->render('AVBundle:Checkout:shipping.html.twig', array('cart' => $cart, 'next_delivery_date' => $next_delivery_date, 'client' => $client, 'shippings' => $shippings, 'next_delivery_date_range' => $next_delivery_date_range));
    }

    public function paymentAction() {
	

        $shopManager = $this->get('ShopManager');

        /* Fetch shopping cart */
        $cart = $shopManager->getCart();

        if ($cart->getId() == null) {

            $shopManager->clear();

            return new RedirectResponse($this->generateUrl('_root'));
        }

        /* Create client */
        if($this->getRequest()->getMethod() == 'POST') { 
            $shopManager->setClientShipping($this->getRequest());
        }
        
        $paymethods = $this->getDoctrine()->getRepository('AVBundle:Paymethod')->findBy(array('isActive' => 1));
        
        /* Fetch discount */
        $discount = $shopManager->getDiscount();

        if (empty($discount)) {
            $discount = '0,00';
        } else {
            $discount = number_format($discount, 2, ',', '.');
        }
        
        return $this->render('AVBundle:Checkout:payment.html.twig', array('cart' => $cart, 'paymethods' => $paymethods, 'discount' => $discount));
    }

    public function overviewAction() {

        $shopManager = $this->get('ShopManager');

        /* Fetch shopping cart */
        $cart = $shopManager->getCart();

        if ($cart->getId() == null) {

            $shopManager->clear();

            return new RedirectResponse($this->generateUrl('_root'));
        }

        /* Create client */
        if($this->getRequest()->getMethod() == 'POST') { 
            $shopManager->setPaymethod($this->getRequest());
        }
        
        $client = $shopManager->getClient();
        
        /* Fetch discount */
        $discount = $shopManager->getDiscount();

        if (empty($discount)) {
            $discount = '0,00';
        } else {
            $discount = number_format($discount, 2, ',', '.');
        }
        
        $next_delivery_date = $shopManager->getShippingDate();
        
        $paymethod = $shopManager->getPaymethod();
        
        return $this->render('AVBundle:Checkout:overview.html.twig', array('cart' => $cart, 'next_delivery_date' => $next_delivery_date, 'client' => $client, 'discount' => $discount, 'paymethod' => $paymethod));
    }

    public function checkoutAction() {
        
        $shopManager = $this->get('ShopManager');

        $msp = new MultiSafePay();

        /*
         * Merchant Settings
         */
        
        if($this->get('kernel')->getEnvironment() == 'dev') { 
            $msp->merchant['account_id'] = '90085841';
            $msp->merchant['site_id'] = '6337';
            $msp->merchant['site_code'] = '953492';
            $msp->test = true;
        } else { 
            $msp->merchant['account_id'] = '10099492';
            $msp->merchant['site_id'] = '9314';
            $msp->merchant['site_code'] = '314849';            
            $msp->test = false;            
        }
        
        $msp->merchant['notification_url'] = ltrim(BASE_URL_AV, '/') . $this->generateUrl('_notify') . '?type=initial';
        $msp->merchant['cancel_url'] = ltrim(BASE_URL_AV, '/') . $this->generateUrl('_checkout_cancel');

        // optional automatic redirect back to the shop:
        $msp->merchant['redirect_url'] = ltrim(BASE_URL_AV, '/') . $this->generateUrl('_checkout_complete');


        if ($this->getRequest()->getMethod() === 'POST') {

            // Create order            
            $shopManager->createOrder($this->getRequest());

            // get variables to send mail
            $order = $shopManager->getOrder();
            $client = $shopManager->getClient();
            $products = $order->getProducts();

            $paymethod = $shopManager->getPaymethod();
            
            // Send order mail
            $message = \Swift_Message::newInstance()
                    ->setSubject('Bevestiging van je bestelling!')
                    ->setFrom('info@addictedToVintage.nl')
                    ->setTo($client->getEmail())
                    ->addPart($this->renderView('AVBundle:Email:order.txt.twig', array('order' => $order, 'products' => $products, 'client' => $client)))
                    ->setBody($this->renderView('AVBundle:Email:order.html.twig', array('order' => $order, 'products' => $products, 'client' => $client)), 'text/html')
            ;

            $this->get('mailer')->send($message);
            
            // Send order mail
            $message = \Swift_Message::newInstance()
                    ->setSubject('Nieuwe bestelling: ' . $order->getOrderNr() . '')
                    ->setFrom('info@addictedToVintage.nl')
                    ->setTo('info@addictedToVintage.nl')
                    ->addPart($this->renderView('AVBundle:Email:order.txt.twig', array('order' => $order, 'products' => $products, 'client' => $client)))
                    ->setBody($this->renderView('AVBundle:Email:order.html.twig', array('order' => $order, 'products' => $products, 'client' => $client)), 'text/html')
            ;

            $this->get('mailer')->send($message);
            
            
            $em = $this->getDoctrine()->getEntityManager();
            
            $client = $this->getDoctrine()->getRepository('AVBundle:Client')->find($client);
            
            $email = new \Ecommerce\AVBundle\Entity\Email();
            $email->setClient($client);
            $email->setContent($this->renderView('AVBundle:Email:order.html.twig', array('order' => $order, 'products' => $products, 'client' => $client)));
            $email->setCreatedAt(new \DateTime());
            $email->setSubject('Bevestiging van je bestelling! ');
            
            $em->persist($email);
            $em->flush();            

            /* Client automatisch inloggen */
            $token = new \Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken($client, null, 'mainsecurity', $client->getRoles());
            $securityContext = $this->get('security.context');
            $securityContext->setToken($token);


            if($shopManager->getPaymethod()->getId() == 13) { // overboeking
                return $this->redirect($this->generateUrl('_checkout_complete'));
            }
            
            /*
             * Customer Details
             */
            $msp->customer['locale'] = 'nl';
            $msp->customer['firstname'] = $client->getName();
            $msp->customer['lastname'] = ' ';
            $msp->customer['zipcode'] = $client->getZipCode();
            $msp->customer['city'] = $client->getLocation();
            $msp->customer['country'] = $client->getCountry();
            $msp->customer['phone'] = $client->getPhone();
            $msp->customer['email'] = $client->getEmail();

            $msp->parseCustomerAddress($client->getAddress());
            // or 
            // $msp->customer['address1']         = $client->getAddress();
            // $msp->customer['housenumber']      = '21';

            /*
             * Transaction Details
             */
            $msp->transaction['id'] = $order->getOrdernr(); // generally the shop's order ID is used here
            $msp->transaction['currency'] = 'EUR';
            $msp->transaction['amount'] = $order->getTotal() * 100; // cents
            $msp->transaction['description'] = 'Order #' . $msp->transaction['id'];
            $msp->transaction['gateway'] = $paymethod->getCode();

            $items = '<ul class="order_products">';

            foreach ($order->getProducts() as $order_product) {
                $items .= '<li>' . $order_product->getAmount() . 'x ' . $order_product->getProduct()->getName() . '</li>';
            }

            $items .= '</ul>';

            $msp->transaction['items'] = $items;

            // returns a payment url
            $url = $msp->startTransaction();

            if ($msp->error) {
                echo "Error " . $msp->error_code . ": " . $msp->error;
                exit();
            }
            
            /* 
            * Client automatisch inloggen 
            */

            $token = new UsernamePasswordToken($client, null, 'mainsecurity', $client->getRoles());
            $securityContext = $this->get('security.context')->setToken($token);

            // redirect
            return new RedirectResponse($url);
        }

        $cart = $shopManager->getCart();

        /* Check if cart is filled with products */
        if ($cart == NULL) {
            return $this->redirect($this->generateUrl('_root'));
        }

        return $this->render('AVBundle:Checkout:index.html.twig', array('cart' => $cart));
    }

    public function checkoutCompleteAction() {

        $order = $this->getDoctrine()->getRepository('AVBundle:Orders')->findOneBy(array('ordernr' => $this->getRequest()->get('transactionid')));

        $shopManager = $this->get('ShopManager');
        
        if ($order == null) {
            $order = $shopManager->getOrder();
        }
        
        $transactionid = $this->getRequest()->get('transactionid');
        
        $this->notifyAction($transactionid);
        
        $shopManager->clear();
        
        return $this->render('AVBundle:Checkout:success.html.twig', array('order' => $order));
    }

    public function checkoutCancelAction() {

        $shopManager = $this->get('ShopManager');
        
        $order = $shopManager->getOrder();
        

        return $this->render('AVBundle:Checkout:cancel.html.twig', array('order' => $order));
    }

    public function notifyAction($transactionid = false) {


        $msp = new MultiSafePay();

        if($transactionid == false) { 
            $transactionid = $this->getRequest()->get('transactionid');
        }
        
        /*
         * Merchant Settings
         */
	if($this->get('kernel')->getEnvironment() == 'dev') { 
            $msp->merchant['account_id'] = '90085841';
            $msp->merchant['site_id'] = '6337';
            $msp->merchant['site_code'] = '953492';
            $msp->test = true;
        } else { 
            $msp->merchant['account_id'] = '10099492';
            $msp->merchant['site_id'] = '9314';
            $msp->merchant['site_code'] = '314849';            
            $msp->test = false;            
        }
        
        /*
         * Transaction Details
         */
        $msp->transaction['id'] = $transactionid;

        // returns the status
        $status = $msp->getStatus();
        
        $order = $this->getDoctrine()->getRepository('AVBundle:Orders')->findOneBy(array('ordernr' => $transactionid));

        if ($order == null) {
            $shopManager = $this->get('ShopManager');
            $order = $shopManager->getOrder();
        }

        $em = $this->getDoctrine()->getEntityManager();

        switch ($status) {
            case "completed":   // payment complete
                $order->setPayed(1);
                $order->setStatus('Betaald');
                break;
            case "initialized": // waiting
                $order->setStatus('Wachten op betaling [AMSP]');
                break;
            case "uncleared":   // waiting (credit cards or direct debit)
                $order->setStatus('Wachten op betaling (cc of dd)');
                break;
            case "void":        // canceled
                $order->setStatus('Betaling geannuleerd');
                break;
            case "declined":    // declined
                $order->setStatus('Betaling afgewezen');
                break;
            case "refunded":    // refunded
                $order->setStatus('Betaling terug gestort');
                break;
            case "expired":     // expired
                $order->setStatus('Betaling verlopen');
                break;
            default:
                $order->setStatus('Wachten op betaling');
                break;
        }
        $em->flush();

        return new Response();
    }
    
    
    private function getNextDeliveryDate() { 
        
        $today = new \DateTime('now');
        $delivery_day = null;
        
        switch($today->format('N')) { 
            
            case "1" :
                $delivery_day = $today->add(new \DateInterval('P2D'));
                break;
            
            case "2" :
                $delivery_day = $today->add(new \DateInterval('P2D'));
                break;
            
            case "3" :
                $delivery_day = $today->add(new \DateInterval('P2D'));
                break;
            
            case "4" :
                $delivery_day = $today->add(new \DateInterval('P2D'));
                break;
            
            case "5" :
                $delivery_day = $today->add(new \DateInterval('P4D'));
                break;
            
            case "6" :
                $delivery_day = $today->add(new \DateInterval('P3D'));
                break;
            
            case "7" :
                $delivery_day = $today->add(new \DateInterval('P2D'));
                break;
            
        }
        
        return $delivery_day;
        
    }
    
    function getNextDeliveryDateRange() { 
     
        $start = $this->getNextDeliveryDate();
        $start->add(new \DateInterval('P1D'));
        
        $range = array();
        
        for($i = 0; $i < 7; $i++) { 
            
            $next = new \DateTime($start->format('d-m-Y'));
            $next->add(new \DateInterval('P' . $i . 'D'));
            
            if($next->format('D') != 'Sun') { 
                $range[] = $next;
            }
        }
        
        return $range;
        
    }

}
