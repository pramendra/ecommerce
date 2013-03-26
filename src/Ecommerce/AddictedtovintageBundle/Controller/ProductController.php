<?php

namespace Ecommerce\AddictedtovintageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AddictedtovintageBundle\Entity\Product;

class ProductController extends Controller {

    public function viewAction($section, $category, $subcategory, $product) {
        
        
        $route = $this->container->get('request')->get('_route');
        
        if($route == '_product') { 
            $show_canonical = true;
        } else { 
            $show_canonical = false;
        }

        $sections = $this->getDoctrine()->getRepository('AddictedtovintageBundle:Section')->findAll();
        
        $product_permalink = str_replace('.html', '', $product);

        $product_repository = $this->getDoctrine()->getRepository('AddictedtovintageBundle:Product');
        $product = $product_repository->findActiveProductByPermalink($product_permalink);
          
        if(!empty($product[0])) { 
            $product = $product[0];
        }
        
        if ($product == null) {
	    return $this->redirect($this->generateUrl('_subcategory', array('section' => $section , 'category' => $category, 'subcategory' => $subcategory)));
            //throw $this->createNotFoundException();
        }
                
        if($product->getDeletedAt() != null) { 
	    return $this->redirect($this->generateUrl('_subcategory', array('section' => $section , 'category' => $category, 'subcategory' => $subcategory)));
            //throw $this->createNotFoundException();
        }
        
        if($product->getActive() != 1) { 
	    return $this->redirect($this->generateUrl('_subcategory', array('section' => $section , 'category' => $category, 'subcategory' => $subcategory)));
            //throw $this->createNotFoundException();
        }
        
        $categories_repository = $this->getDoctrine()->getRepository('AddictedtovintageBundle:Category');
        $category = $categories_repository->findOneByPermalink($category);
        
        $subcategories_repository = $this->getDoctrine()->getRepository('AddictedtovintageBundle:Subcategory');
        $subcategory = $subcategories_repository->findOneByPermalink($subcategory);
        
        $sections_repository = $this->getDoctrine()->getRepository('AddictedtovintageBundle:Section');
        $section = $sections_repository->findOneByPermalink($section);
     
        $attribute = null;
        $related_products = null;
//        
//        foreach($product->getAttributes() as $product_attribute) { 
//            
//            if($product_attribute->getAttribute()->getId() == 4) { 
//                $attribute = $product_attribute;
//            }
//        }
//        
//        if($attribute != null) { 
//            $related_products = $this->getDoctrine()->getRepository('AddictedtovintageBundle:Product')->findRelatedProductsByAttribute($subcategory, $attribute, 4, $product);
//        }
//        
        if($related_products == null) { 
            $related_products = $this->getDoctrine()->getRepository('AddictedtovintageBundle:Product')->getActiveProductsBySubcategory($subcategory, 4);
        }
        
        $sale_discount = $this->container->getParameter('sale_discount');
        
        /* 
        * PageManager aanroepen
        */
        $pm = $this->get('PageManager');
        
        $pm->setPermalink('/{generic}/{generic}/{generic}/{generic}');

        $page = $pm->pageParser(array('title' => $product->getName(),'description' => $product->getDescription(), 'subcategory' => $subcategory->getName()));

        return $this->render('AddictedtovintageBundle:Product:index.html.twig', array('sale_discount' => $sale_discount, 'product' => $product, 'category' => $category, 'section' => $section, 'subcategory' => $subcategory, 'page' => $page, 'sections' => $sections, 'related_products' => $related_products, 'show_canonical' => $show_canonical  ));
    }

    public function shortcutAction($product) {
        
        $product_permalink = str_replace('.html', '', $product);

        $product_repository = $this->getDoctrine()->getRepository('AddictedtovintageBundle:Product');
        $product = $product_repository->findOneByPermalink($product_permalink);
        
        if (!$product) {
            
            $categories_repository = $this->getDoctrine()->getRepository('AddictedtovintageBundle:Category');
            $category = $categories_repository->findOneByPermalink($product_permalink);
            
            if($category != null) { 
                
                $sections = $category->getSections();
		
                if($sections != null) { 
                    $section = $sections[0];
		    
		    if($section != null) {
			return $this->redirect($this->generateUrl('_category', array('section' => $section->getPermalink() , 'category' => $category->getPermalink())));
		    } else { 
			throw $this->createNotFoundException();
		    }
                } else { 
		    throw $this->createNotFoundException();
		}
            }
            
            $subcategorie_repository = $this->getDoctrine()->getRepository('AddictedtovintageBundle:Subcategory');
            $subcategory = $subcategorie_repository->findOneByPermalink($product_permalink);
            
            if($subcategory != null) { 
                
                $categories = $subcategory->getCategories();
                
                if($categories != null) { 
                    
                    $category = $categories[0];                    
                    $sections = $category->getSections();
                    
                    if($sections != null) { 
                        $section = $sections[0];
                        
                        return $this->redirect($this->generateUrl('_subcategory', array('section' => $section->getPermalink() , 'category' => $category->getPermalink(), 'subcategory' => $subcategory->getPermalink())));
                    }
                }
            }
            
            return $this->redirect($this->generateUrl('_root'));
        }
        
        $subcategories = $product->getSubcategories();
        
        if(!empty($subcategories[0])) { 
            $subcategory = $subcategories[0];
        } else { 
            throw $this->createNotFoundException();
        }
        
        $categories = $subcategory->getCategories();
        
        if(!empty($categories[0])) { 
            $category = $categories[0];
        } else { 
            throw $this->createNotFoundException();
        }
        
        $sections = $category->getSections();
        
        if(!empty($sections[0])) { 
            $section = $sections[0];
        } else { 
            throw $this->createNotFoundException();
        }
        
        return $this->redirect($this->generateUrl('_product', array('product' => $product->getPermalink(), 'category' => $category->getPermalink(), 'section' => $section->getPermalink(), 'subcategory' => $subcategory->getPermalink())));
    }

}
