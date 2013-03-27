<?php

namespace Ecommerce\SGBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use SGBundle\Entity\Product;
use Ecommerce\SGBundle\Paginator\Paginator;

class CategoryController extends Controller {

    public function indexAction($section, $category) {
        
        $category_permalink = $category;
        $section_permalink = $section;

        $categories_repository = $this->getDoctrine()->getRepository('SGBundle:Category');
        $category = $categories_repository->findOneByPermalink($category_permalink);
        
        if($category == null) { 
            return $this->forward('SGBundle:Product:shortcut', array('product' => $category_permalink));
        }

        $sections_repository = $this->getDoctrine()->getRepository('SGBundle:Section');
        $section = $sections_repository->findOneByPermalink($section_permalink);
        
        if($section == null) { 
            throw $this->createNotFoundException();
        }
        
        
        if($category->getActive() == 0) { 
            return $this->redirect($this->generateUrl('_section', array('section' => $section->getPermalink())));
        }

        $sections = $sections_repository->findAll();
        
        /* Fetch subcategory */
        $subcategorie_repository = $this->getDoctrine()->getRepository('SGBundle:Subcategory');
        $subcategories = $subcategorie_repository->getActiveSubcategoriesByCategory($category);
        
        $page = $this->getDoctrine()->getRepository('SGBundle:Page')->findOneBy(array('permalink' => $section_permalink .'/'.$category_permalink));
        
        /* Installing product filter */
        $productFilter = $this->get('ProductFilter');
        
        /* Clear filter if category changed */        
        if($productFilter->getCategory() != null) { 
        
            if($productFilter->getCategory()->getId() != $category->getId()) { 
                $productFilter->clearFilter();
            }        
        
        }
        
        $productFilter->setIsSale(false);
        
        /* Set subcategory */
        $productFilter->clearSubcategory();
        $productFilter->setCategory($category);

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
            $active_products = $this->getDoctrine()->getRepository('SGBundle:Product')->findAllProductsByCategory($category);
            $attribute_values = $categories_repository->getDistinctProductAttributes($active_products);
            $totalProducts = count($active_products);
        }
        
        $baseUrl = $this->generateUrl('_category', array('section' => $section->getPermalink() , 'category' => $category->getPermalink()));
        
        $paginator = new Paginator($totalProducts, $current_page, $productFilter->getMaxResults(), $baseUrl);
        
        if($page == null) { 
            /* 
            * PageManager aanroepen
            */
            $pm = $this->get('PageManager');

            $pm->setPermalink('/{generic}/{generic}');

            $page = $pm->pageParser(array('category' => $category->getName(), 'section' => $section->getName()));
        }
        
        return $this->render('SGBundle:Category:index.html.twig', array(
                    'subcategories' => $subcategories,
                    'section' => $section,
                    'sections' => $sections,
                    'products' => $products,
                    'page' => $page,
                    'current_page' => $current_page,
                    'attributes' => $attributes,
                    'attribute_values' => $attribute_values,
                    'paginator' => $paginator,
                    'total_products' => $totalProducts,
                    'productfilter' => $productFilter,
                    'category' => $category));
    }
    
    public function subcategoryAction($section, $category, $subcategory) {

        $sections_repository = $this->getDoctrine()->getRepository('SGBundle:Section');

        /* Fetch section by permalink */
        $section = $sections_repository->findOneByPermalink($section);
        $sections = $sections_repository->findAll();
        
        if($section == null) { 
            throw $this->createNotFoundException();
        }
        
        $categories_repository = $this->getDoctrine()->getRepository('SGBundle:Category');

        /* Fetch category by permalink */
        $category = $categories_repository->findOneByPermalink($category);

        /* Fetch subcategory */
        $subcategorie_repository = $this->getDoctrine()->getRepository('SGBundle:Subcategory');
        $subcategory = $subcategorie_repository->findOneByPermalink($subcategory);
        
        if($subcategory == null) { 
            throw $this->createNotFoundException();
        }
        
        if($subcategory->getActive() == 0) { 
            return $this->redirect($this->generateUrl('_category', array('section' => $section->getPermalink() , 'category' => $category->getPermalink())));
        }
        
        
        /* Installing product filter */
        $productFilter = $this->get('ProductFilter');
        
        /* Clear filter if subcategory changed */        
        
        if($productFilter->getSubcategory() != null) { 
        
            if($productFilter->getSubcategory()->getId() != $subcategory->getId()) { 
                $productFilter->clearFilter();
            }        
        
        }
        $productFilter->clearCategory();
        
        /* Set subcategory */
        $productFilter->setSubcategory($subcategory);
        
        $productFilter->setIsSale(false);

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
            
            $active_products = $this->getDoctrine()->getRepository('SGBundle:Product')->getActiveProductsBySubcategory($subcategory);
            
            $attribute_values = $categories_repository->getDistinctProductAttributes($active_products);
            $totalProducts = count($active_products);
        }

        $baseUrl = $this->generateUrl('_subcategory', array('section' => $section->getPermalink() , 'category' => $category->getPermalink(), 'subcategory' => $subcategory->getPermalink()));
        
        $paginator = new Paginator($totalProducts, $current_page, $productFilter->getMaxResults(), $baseUrl);
        
        #print_r ( $paginator->getRange() )  ; die();
        
         /* 
        * PageManager aanroepen
        */
        $pm = $this->get('PageManager');
        
        $pm->setPermalink('/{generic}/{generic}/{generic}');

        $page = $pm->pageParser(array('subcategory' => $subcategory->getName(), 'category' => $category->getName(), 'section' => $section->getName()));
        
        return $this->render('SGBundle:Subcategory:index.html.twig', array(
                    'products' => $products,
                    'page' => $page,
                    'subcategory' => $subcategory,
                    'attribute_values' => $attribute_values,
                    'paginator' => $paginator,
                    'section' => $section,
                    'sections' => $sections,
		    'current_page' => $current_page,
                    'total_products' => $totalProducts,
                    'productfilter' => $productFilter,
                    'attributes' => $attributes,
                    'category' => $category));
    }

}
