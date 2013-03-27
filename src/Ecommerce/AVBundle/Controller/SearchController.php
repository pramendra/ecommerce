<?php

namespace Ecommerce\AVBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AVBundle\Entity\Product;
use AVBundle\Entity\Cart;

class SearchController extends Controller {

    public function indexAction() {
               
        $products = array();
        
        if ($this->getRequest()->getMethod() === 'POST') {

            $q = $this->get('request')->request->get('q');
            
            if($q !== null) { 
            
                $products_repository = $this->getDoctrine()->getRepository('AVBundle:Product');
                $products = $products_repository->searchProductsByKeyword($q);
            }
        }
        
        if(count($products) == 1) { 
            return $this->redirect($this->generateUrl('_product_shortcut', array('product' => $products[0]->getPermalink())));
        }
        
        return $this->render('AVBundle:Search:index.html.twig', array('products' => $products));
    }

    public function jsonAction() {
               
        $result = array();
        
        if ($this->getRequest()->getMethod() === 'POST') {

            $q = $this->get('request')->request->get('q');
            
            if($q !== null) { 
            
                $products_repository = $this->getDoctrine()->getRepository('AVBundle:Product');
                
                $products = $products_repository->searchProductsByKeyword($q);
                
                foreach($products as $product) { 
                    $result[] = $product->getName();
                }
            }
        }
        
        $response = new Response(json_encode($result));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

}
