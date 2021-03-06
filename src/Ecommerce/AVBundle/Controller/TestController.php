<?php

namespace Ecommerce\AVBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ecommerce\AVBundle\Entity\ProductAttributes;

class TestController extends Controller {

    
    public function indexAction() {

        $em = $this->getDoctrine()->getEntityManager();

        $search = 'off white / geel / groen ';
        
        $val1 = 'off white';
        $val2 = 'geel';
//        $val3 = 'groen';
        
        $product_attributes = $this->getDoctrine()->getRepository('AVBundle:ProductAttributes')->findbyAttributeLike($search);
        
        echo '<ul>';
        
        foreach($product_attributes as $pa) { 
            
            
            echo '<li>' . $pa->getAttributeValue() . '</li>';
            
            $attribute = $this->getDoctrine()->getRepository('AVBundle:Attribute')->find($pa->getAttribute()->getId());
            $product = $this->getDoctrine()->getRepository('AVBundle:Product')->find($pa->getProduct()->getId());
            
            $new_pa = new ProductAttributes();
            $new_pa->setAttribute($attribute);
            $new_pa->setAttributeValue($val1);
            $new_pa->setIsSelectable(false);
            $new_pa->setProduct($product);
            
            $pa->setAttributeValue($val2);
            
            $em->persist($new_pa);
            
//            $new_pa2 = new ProductAttributes();
//            $new_pa2->setAttribute($attribute);
//            $new_pa2->setAttributeValue($val3);
//            $new_pa2->setIsSelectable(false);
//            $new_pa2->setProduct($product);
//            
//            $em->persist($new_pa2);
            
            $em->flush();
            
        }
        
        $em->flush();
        
        echo '</ul>';
        
        return new \Symfony\Component\HttpFoundation\Response();
    }
    
    public function emailAction() { 
        
        $order = $this->getDoctrine()->getRepository('AVBundle:Orders')->find(22);
        
        return $this->render('AVBundle:Email:order.html.twig', array('order' => $order));
        
        
    }
}
