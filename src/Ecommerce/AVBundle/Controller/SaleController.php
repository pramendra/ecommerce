<?php

namespace Ecommerce\AVBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AVBundle\Entity\Product;
use Ecommerce\AVBundle\Paginator\Paginator;

class SaleController extends Controller {

    public function indexAction() {
        
        $sections_repository = $this->getDoctrine()->getRepository('AVBundle:Section');

        /* Fetch section by permalink */
        $sections = $sections_repository->findAll();
        
        /* Installing product filter */
        $productFilter = $this->get('ProductFilter');
        
        /* Clear filter */        
        $productFilter->setSubcategory(null);
        
        /* Set sale */
        $productFilter->setIsSale(true);
        
        $page = $this->getRequest()->get('page');

        if (empty($page)) {
            $page = 0;
            $firstResult = 0;
        } else {
            $firstResult = ($page * $productFilter->getMaxResults()) + 1;
        }

        $products = $this->getDoctrine()->getRepository('AVBundle:Product')->findByOffsetAndFilter($firstResult, $productFilter);

        $totalProducts = count($products);
        
        $baseUrl = $this->generateUrl('_sale');        
        $paginator = new Paginator($totalProducts, $page, $productFilter->getMaxResults(), $baseUrl);
        
        $sale_discount = $this->container->getParameter('sale_discount');
        
        $page = $this->getDoctrine()->getRepository('AVBundle:Page')->findOneBy(array('permalink' => 'sale'));
        
        return $this->render('AVBundle:Sale:index.html.twig', array(
                    'products' => $products,
                    'page' => $page,
                    'sale_discount' => $sale_discount,
                    'paginator' => $paginator,
                    'total_products' => $totalProducts,
                    'sections' => $sections,
                    'section' => null,
                    'productfilter' => $productFilter));
    }

}
