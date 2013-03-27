<?php

namespace Ecommerce\SGBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SeoController extends Controller {

    public function viewAction($permalink) {
        
	
        $product_permalink = str_replace('.html', '', $permalink);

        $product_repository = $this->getDoctrine()->getRepository('SGBundle:Product');
        $product = $product_repository->findOneByPermalink($product_permalink);

	if($product != null) { 
            return $this->forward('SGBundle:Product:shortcut', array('product' => $permalink));
        }
        
        $page = $this->getDoctrine()->getRepository('SGBundle:Page')->findOneBy(array('permalink' => $permalink));
        
		
	if($page == null) {
	    return $this->redirect($this->generateUrl('_root'));
	} 
	
        if($page->getLandingpageKeyword() == null) { 
            return $this->forward('SGBundle:Page:view', array('permalink' => $permalink));
        }

        $sections = $this->getDoctrine()->getRepository('SGBundle:Section')->findAll();
             
        $exp = explode('|', $page->getLandingpageKeyword());
        
        $section = $this->getDoctrine()->getRepository('SGBundle:Section')->find($exp[0]);
        $keyword = $exp[1];
        
        $products = $this->getDoctrine()->getRepository('SGBundle:Product')->findProductsBySectionAndKeyword($section, $keyword);
        
        $page->setDescription( \str_replace('{count}', count($products), $page->getDescription()));
        
        return $this->render('SGBundle:Seo:index.html.twig', array('page' => $page, 'products' => $products, 'section' => $section, 'sections' => $sections));

    }

}
