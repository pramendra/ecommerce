<?php

namespace Ecommerce\SGBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use SGBundle\Entity\Product;
use Ecommerce\SGBundle\Paginator\Paginator;

class SectionController extends Controller {

    
    public function indexAction($section) {
        
        $permalink = $section;
        
        $sections_repository = $this->getDoctrine()->getRepository('SGBundle:Section');
        $categories_repository = $this->getDoctrine()->getRepository('SGBundle:Category');
        $section = $sections_repository->findOneByPermalink($section);
        
        $sections = $sections_repository->findAll();

        if($section === null) { 
            return $this->forward('SGBundle:Seo:view', array('permalink' => $permalink));
        }
        
         /* Installing product filter */
        $productFilter = $this->get('ProductFilter');
        
        $productFilter->clearFilter();
        
        $productFilter->setIsSale(false);
        
        /* Set subcategory */
        $productFilter->setSection($section);
        $productFilter->clearCategory();
        $productFilter->clearSubcategory();

        $current_page = $this->getRequest()->get('page');

        if (empty($current_page)) {
            $current_page = 0;
            $firstResult = 0;
        } else {
            $firstResult = ($current_page * $productFilter->getMaxResults()) + 1;
        }

        $products = $this->getDoctrine()->getRepository('SGBundle:Product')->findByOffsetAndFilter($firstResult, $productFilter);
        
        $attribute_repository = $this->getDoctrine()->getRepository('SGBundle:Attribute');
        $attributes = $attribute_repository->findBy(array('isFilterable' => true));
        
        if($productFilter->getAttributes() !== null) { 
            $attribute_values = $categories_repository->getDistinctProductAttributes($products);
            $totalProducts = count($products);
        } else { 
            $active_products = $this->getDoctrine()->getRepository('SGBundle:Product')->findLatestProductsBySection($section);
            $attribute_values = $categories_repository->getDistinctProductAttributes($active_products);
            $totalProducts = count($active_products);
        }

        //$products = $this->getDoctrine()->getRepository('SGBundle:Product')->findLatestProductsBySection($section);
        
        $baseUrl = $this->generateUrl('_section', array('section' => $section->getPermalink()));
        
        $paginator = new Paginator($totalProducts, $current_page, $productFilter->getMaxResults(), $baseUrl);
        
        $page = $this->getDoctrine()->getRepository('SGBundle:Page')->findOneBy(array('permalink' => $section->getPermalink()));
        
        return $this->render('SGBundle:Section:index.html.twig', array('section' => $section, 
            'sections' => $sections, 'products' => $products, 
            'attributes' => $attributes,
            'attribute_values' => $attribute_values,
            'paginator' => $paginator,
            'total_products' => $totalProducts,
	    'current_page' => $current_page,
            'productfilter' => $productFilter,
            'page' => $page, 'paginator' => $paginator));
    }
    
    public function menuAction() {

        /* Fetch categories */
        $section_repository = $this->getDoctrine()->getRepository('SGBundle:Section');
        $sections = $section_repository->findAll();

        return $this->render('SGBundle:Section:menu.html.twig', array('sections' => $sections));
    }

}
