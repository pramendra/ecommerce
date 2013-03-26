<?php

namespace BiologischeKaas\EcommerceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    
    public function indexAction()
    {
        $latest_products = $this->getDoctrine()->getRepository('EcommerceBundle:Product')->findLatestProducts(12);
        
        /* 
        * PageManager aanroepen
        */
        $pm = $this->get('PageManager');
        
        $page = $pm->setPermalink('{homepage}');

    	return $this->render('EcommerceBundle:Default:index.html.twig', array('latest_products' => $latest_products, 'page' => $page));
    }
}
