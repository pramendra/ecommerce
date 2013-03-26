<?php

namespace BiologischeKaas\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class OrdersController extends Controller {

    public function indexAction() {

	$query_string = $this->getRequest()->getQueryString();

	$paymethods = $this->getDoctrine()->getRepository('EcommerceBundle:Paymethod')->findAll();
	$shippings = $this->getDoctrine()->getRepository('EcommerceBundle:Shipping')->findAll();

	$selected_paymethod = $this->getRequest()->get('paymethod');
	$selected_status = $this->getRequest()->get('status');
	$selected_shipping = $this->getRequest()->get('shipping');

	return $this->render('AdminBundle:Orders:index.html.twig', array('query_string' => $query_string, 'paymethods' => $paymethods, 'shippings' => $shippings,
		    'selected_paymethod' => $selected_paymethod,
		    'selected_status' => $selected_status,
		    'selected_shipping' => $selected_shipping,
	));
    }

    public function viewAction($id) {

	$order = $this->getDoctrine()->getRepository('EcommerceBundle:Orders')->find($id);

	return $this->render('AdminBundle:Orders:view.html.twig', array('order' => $order));
    }

    public function sendOrderMailAction($id) {

	$order = $this->getDoctrine()->getRepository('EcommerceBundle:Orders')->find($id);
	$client = $order->getClient();
	$products = $order->getProducts();

	// Send order mail
	$message = \Swift_Message::newInstance()
		->setSubject('Bevestiging van je bestelling!')
		->setFrom('info@addictedToVintage.nl')
		->setTo($client->getEmail())
		->addPart($this->renderView('EcommerceBundle:Email:order.txt.twig', array('order' => $order, 'products' => $products, 'client' => $client)))
		->setBody($this->renderView('EcommerceBundle:Email:order.html.twig', array('order' => $order, 'products' => $products, 'client' => $client)), 'text/html')
	;

	$this->get('mailer')->send($message);

	$em = $this->getDoctrine()->getEntityManager();

	$email = new \BiologischeKaas\EcommerceBundle\Entity\Email();
	$email->setClient($client);
	$email->setContent($this->renderView('EcommerceBundle:Email:order.txt.twig', array('order' => $order, 'products' => $products, 'client' => $client)));
	$email->setCreatedAt(new \DateTime());
	$email->setSubject('Bestelmail opnieuw verzonden: ' . $order->getOrderNr() . '');

	$em->persist($email);
	$em->flush();

	$response = new Response(json_encode(true));
	$response->headers->set('Content-Type', 'application/json');

	return $response;
    }

    public function sendAction($id) {

	$order = $this->getDoctrine()->getRepository('EcommerceBundle:Orders')->find($id);

	if ($order->getShipping()->getId() == 1) {

	    $em = $this->getDoctrine()->getEntityManager();

	    $shipping_code = $this->getRequest()->get('shipping_code');
	    $order->setShippingCode($shipping_code);
	}

	// Send send_order mail
	$message = \Swift_Message::newInstance()
		->setSubject('Bestelling verzonden! (' . $order->getOrderNr() . ')')
		->setFrom('info@addictedToVintage.nl')
		->setTo($order->getClient()->getEmail())
		->addPart($this->renderView('EcommerceBundle:Email:order_shipped.txt.twig', array('order' => $order)))
		->setBody($this->renderView('EcommerceBundle:Email:order_shipped.html.twig', array('order' => $order)), 'text/html')
	;

	$this->get('mailer')->send($message);

	$order->setStatus('Verzonden');

	$em->flush();

	return $this->redirect($this->generateUrl('admin_order', array('id' => $order->getId())));
    }

    public function jsonSetOrderPayedAction($id) {

	$em = $this->getDoctrine()->getEntityManager();

	$order = $this->getDoctrine()->getRepository('EcommerceBundle:Orders')->find($id);
	$order->setPayed(1);
	$order->setStatus('Betaald');

	$em->flush();

	$result = $order->__toJson();

	$response = new Response(json_encode($result));
	$response->headers->set('Content-Type', 'application/json');

	return $response;
    }

    public function jsonOrdersAction() {

	/*
	  <select name="status">
	  <option value="0">Alle bestellingen</option>
	  <option value="1">Niet betaalde bestellingen</option>
	  <option value="2">Betaalde bestellingen</option>
	  <option value="3">Afgeronde bestellingen</option>
	  <option value="4">Geannuleerde bestellingen</option>
	  </select>
	  <select name="paymethod">
	  <option value="0">Alle betaalwzijzen</option>
	  <option value="1">iDEAL</option>
	  <option value="2">Bankoverschrijving</option>
	  <option value="3">Overige betaalwijzen</option>
	  </select>
	  <select name="shipping">
	  <option value="0">Alle verzendwzijzen</option>
	  <option value="1">PostNL pakket</option>
	  <option value="2">Brievenpost</option>
	  </select>
	 */


	$status = $this->getRequest()->get('status');

	if ($status != null) {

	    $paymethod = $this->getDoctrine()->getRepository('EcommerceBundle:Paymethod')->find($this->getRequest()->get('paymethod'));
	    $shipping = $this->getDoctrine()->getRepository('EcommerceBundle:Shipping')->find($this->getRequest()->get('shipping'));

	    $orders = $this->getDoctrine()->getRepository('EcommerceBundle:Orders')->findOrdersByAdminFilter($status, $paymethod, $shipping);
	} else {
	    $orders = $this->getDoctrine()->getRepository('EcommerceBundle:Orders')->findAll();
	}

	$result = array();

	foreach ($orders as $order) {

	    $products = $order->getProducts();

	    $product_list = '<ul class="unstyled">';

	    foreach ($products as $product) {

		$product_list .= '<li>' . $product->getAmount() . 'x ' . $product->getProduct()->getName() . '</li>';
	    }

	    $product_list .= '</ul>';

	    $createdAt = '<span class="hide">' . $order->getCreatedAt()->format("YmdHi") . '</span>' . $order->getCreatedAt()->format('d-m-Y H:i');


	    $result['aaData'][] = array('<a href="' . $this->generateUrl('admin_order', array('id' => $order->getId())) . '">' . $order->getOrderNr() . '</a>', $order->getClient()->getName(), $product_list, '&euro;' . number_format($order->getTotal(), 2), $order->getStatus(), $createdAt);

	    unset($product_list);
	    unset($products);
	}

	$response = new Response(json_encode($result));
	$response->headers->set('Content-Type', 'application/json');

	return $response;
    }

}
