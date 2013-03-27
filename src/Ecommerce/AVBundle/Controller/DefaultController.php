<?php

namespace Ecommerce\AVBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    
    public function indexAction()
    {
        $latest_products = $this->getDoctrine()->getRepository('AVBundle:Product')->findLatestProducts(12);
        
        /* 
        * PageManager aanroepen
        */
        $pm = $this->get('PageManager');
        
        $page = $pm->setPermalink('{homepage}');

    	return $this->render('AVBundle:Default:index.html.twig', array('latest_products' => $latest_products, 'page' => $page));
    }
}
