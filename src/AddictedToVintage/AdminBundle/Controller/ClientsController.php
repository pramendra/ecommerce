<?php

namespace AddictedToVintage\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class ClientsController extends Controller {

    public function indexAction() {

	return $this->render('AdminBundle:Clients:index.html.twig');
    }

    public function contactAction($id) {

	$client = $this->getDoctrine()->getRepository('EcommerceBundle:Client')->find($id);

	$emaillog = $this->getDoctrine()->getRepository('EcommerceBundle:Email')->findBy(array('client' => $id));

	$email = new \AddictedToVintage\EcommerceBundle\Entity\Email();

	$email->setClient($client);

	$email_form = $this->createForm(new \AddictedToVintage\AdminBundle\Form\EmailType($email), $email);

	$email_form->setData($email);

	if ($this->getRequest()->getMethod() == 'POST') {

	    $email_form->bindRequest($this->getRequest());

	    if ($email_form->isValid()) {

		$em = $this->getDoctrine()->getEntityManager();

		$request = Request::createFromGlobals();
		$postData = $request->request->get('Email');

		$email->setCreatedAt(new \DateTime());

		$em->persist($email);

		$em->flush();

		// Send order mail
		$message = \Swift_Message::newInstance()
			->setSubject($email->getSubject())
			->setFrom('info@addictedToVintage.nl')
			->setTo($email->getClient()->getEmail())
			->addPart($this->renderView('EcommerceBundle:Email:client_contact.txt.twig', array('email' => $email)))
			->setBody($this->renderView('EcommerceBundle:Email:client_contact.html.twig', array('email' => $email)), 'text/html')
		;

		$this->get('mailer')->send($message);

		return $this->redirect($this->generateUrl('admin_contact_client', array('id' => $client->getId())));
	    }
	}

	return $this->render('AdminBundle:Clients:contact.html.twig', array('client' => $client, 'email_form' => $email_form->createView(), 'emaillog' => $emaillog));
    }

    public function viewAction($id) {
	$client = $this->getDoctrine()->getRepository('EcommerceBundle:Client')->find($id);

	$client_form = $this->createForm(new \AddictedToVintage\AdminBundle\Form\ClientType($client), $client);

	$client_form->setData($client);

	if ($this->getRequest()->getMethod() == 'POST') {

	    //$old_password = $member->getPassword();

	    $client->setUpdatedAt(new \DateTime());

	    $client_form->bindRequest($this->getRequest());

	    if ($client_form->isValid()) {

		$em = $this->getDoctrine()->getEntityManager();

		$request = Request::createFromGlobals();
		$postData = $request->request->get('Client');
		/*
		  if ($member->getPassword() == NULL) {
		  $member->setPassword($old_password);
		  } else {
		  $member->setPassword(sha1($member->getPassword()));
		  }
		 */
		$em->flush();

		return $this->redirect($this->generateUrl('admin_client', array('id' => $client->getId())));
	    }
	}

	return $this->render('AdminBundle:Clients:edit.html.twig', array('client' => $client, 'clients_form' => $client_form->createView()));
    }

    public function jsonClientsAction() {

	$clients = $this->getDoctrine()->getRepository('EcommerceBundle:Client')->findAll();

	$result = array();

	foreach ($clients as $client) {

	    $created_at = $client->getCreatedAt()->format('d-m-Y H:i');

	    $result['aaData'][] = array($client->getId(), '<a href="' . $this->generateUrl('admin_client', array('id' => $client->getId())) . '">' . $client->getName() . '</a>', $client->getLocation(), $client->getEmail(), $created_at);
	}

	$response = new Response(json_encode($result));
	$response->headers->set('Content-Type', 'application/json');

	return $response;
    }

}
