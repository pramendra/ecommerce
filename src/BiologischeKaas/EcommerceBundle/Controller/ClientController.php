<?php

namespace BiologischeKaas\EcommerceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Response;

class ClientController extends Controller {

    public function indexAction() {

        $client = $this->get('security.context')->getToken()->getUser();

        $client_form = $this->createForm(new \BiologischeKaas\AdminBundle\Form\ClientType($client), $client);

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

        $TotalOrdersPrice = $this->getDoctrine()->getRepository('EcommerceBundle:Orders')->getTotalOrdersPrice($client);
        
        return $this->render('EcommerceBundle:Client:index.html.twig', array(
            'TotalOrdersPrice' => $TotalOrdersPrice, 'stamp_amount' => 10, 'clients_form' => $client_form->createView()));
    }

    public function loginAction() {
        $request = $this->getRequest();
        $session = $request->getSession();

        // get the login error if there is one
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }

        return $this->render('EcommerceBundle:Security:login.html.twig', array(
                    // last username entered by the user
                    'last_username' => $session->get(SecurityContext::LAST_USERNAME),
                    'error' => $error,
                ));
    }

    public function addressLookupAction() {


        if ($this->getRequest()->getMethod() === 'POST') {

            $request = $this->getRequest();
            $zipcode = $request->get('zipcode');


            $postcode_repository = $this->getDoctrine()->getRepository('EcommerceBundle:Postcode');
            $result = $postcode_repository->getAdrressByPostcode($zipcode);

            $response = new Response(json_encode(array('result' => $result)));
            $response->headers->set('Content-Type', 'application/json');
        }

        return $response;
    }
}
