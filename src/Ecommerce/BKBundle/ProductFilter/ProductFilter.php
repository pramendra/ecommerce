<?php

namespace Ecommerce\BKBundle\ProductFilter;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use Ecommerce\BKBundle\Entity\Attribute;
use Ecommerce\BKBundle\Entity\Subcategory;
use Ecommerce\BKBundle\Entity\Category;
use Ecommerce\BKBundle\Entity\Section;

class ProductFilter extends ContainerAware {

    private $session;
    private $request;
    
    private $attributes;
    private $is_sale;
    private $attribute_values;
    
    private $sortby;
    private $orderby;
    
    private $products;
    
    private $subcategory;
    private $category;
    private $section;
    private $maxResults;

    function __construct() {
        
    }

    function initialize() {

        $this->request = $this->getRequest();
        $this->session = $this->request->getSession();
        
        if ($this->session->get('filter_attributes') !== null) {
            $this->attributes = $this->session->get('filter_attributes');
        } else {
            $this->attributes = null;
            $this->session->set('filter_attributes', $this->attributes);
        }
        
        if ($this->session->get('filter_is_sale') !== null) {
            $this->is_sale = $this->session->get('filter_is_sale');
        } else {
            $this->is_sale = null;
            $this->session->set('filter_is_sale', $this->is_sale);
        }
        
        if ($this->session->get('filter_attribute_values') !== null) {
            $this->attribute_values = $this->session->get('filter_attribute_values');
        } else {
            $this->attribute_values = null;
            $this->session->set('filter_attribute_values', $this->attribute_values);
        }
        
        if ($this->session->get('filter_orderby') !== null) {
            $this->orderby = $this->session->get('filter_orderby');
        } else {
            $this->orderby = 'DESC';
            $this->session->set('filter_orderby', $this->orderby);
        }
        
        if ($this->session->get('filter_sortby') !== null) {
            $this->sortby = $this->session->get('filter_sortby');
        } else {
            $this->sortby = 'NEWEST_FIRST';
            $this->session->set('filter_sortby', $this->sortby);
        }
        
        if ($this->session->get('filter_subcategory') !== null) {
            $this->subcategory = $this->session->get('filter_subcategory');
        } else {
            $this->subcategory = null;
            $this->session->set('filter_subcategory', $this->subcategory);
        }
        
        if ($this->session->get('filter_category') !== null) {
            $this->category = $this->session->get('filter_category');
        } else {
            $this->category = null;
            $this->session->set('filter_category', $this->category);
        }
        
        if ($this->session->get('filter_section') !== null) {
            $this->section = $this->session->get('filter_section');
        } else {
            $this->section = null;
            $this->session->set('filter_section', $this->section);
        }
        
        if ($this->session->get('filter_max_results') !== null) {
            $this->maxResults = $this->session->get('filter_max_results');
        } else {
            $this->maxResults = 15;
            $this->session->set('filter_max_results', $this->maxResults);
        }
        
        if ($this->session->get('filter_products') !== null) {
            $this->products = $this->session->get('filter_products');
        } else {
            $this->products = null;
            $this->session->set('filter_products', $this->products);
        }
    }
    
    public function getSubcategory() { 
        return $this->subcategory;
    }
    
    public function setSubcategory(Subcategory $subcategory = null) { 
        $this->subcategory = $subcategory;
        $this->session->set('filter_subcategory', $this->subcategory);
        
        return $this->subcategory;
    }
    
    public function getCategory() { 
        return $this->category;
    }
    
    public function setCategory(Category $category) { 
        $this->category = $category;
        $this->session->set('filter_category', $this->category);
        
        return $this->category;
    }
    
    public function getSection() { 
        return $this->section;
    }
    
    public function setSection(Section $section) { 
        $this->section = $section;
        $this->session->set('filter_category', $this->section);
        
        return $this->section;
    }
    
    public function clearCategory() { 
        $this->category = null;
        $this->session->set('filter_category', $this->category);
    }
    
    public function clearSection() { 
        $this->section = null;
        $this->session->set('filter_section', $this->section);
    }
    public function clearSubcategory() { 
        $this->subcategory = null;
        $this->session->set('filter_subcategory', $this->subcategory);
    }
    
    public function getMaxResults() { 
        return $this->maxResults;
    }
    
    public function setMaxResults($maxResults) { 
        $this->maxResults = $maxResults;
        $this->session->set('filter_max_results', $this->maxResults);
        
        return $this->maxResults;
    }
    
    public function getProducts() { 
        return $this->products;
    }
    
    public function setProducts($products) { 
        $this->products = $products;
        $this->session->set('filter_products', $this->products);
        
        return $this->products;
    }
    
    public function getIsSale() { 
        return $this->is_sale;
    }
    
    public function setIsSale($isSale) { 
        $this->is_sale = $isSale;
        $this->session->set('filter_is_sale', $this->is_sale);
        
        return $this->is_sale;
    }
    
    public function getSortBy() { 
        return $this->sortby;
    }
    
    public function setSortBy($sortBy) { 
        $this->sortby = $sortBy;
        $this->session->set('filter_sortby', $this->sortby);
        
        return $this->sortby;
    }
    
    public function getOrderBy() { 
        return $this->orderby;
    }
    
    public function setOrderBy($orderBy) { 
        $this->orderby = $orderBy;
        $this->session->set('filter_orderby', $this->orderby);
        
        return $this->orderby;
    }

    public function getAttributes() {
        return $this->attributes;
    }

    public function getAttributeValues() {
        return $this->attribute_values;
    }
   
    public function addAttribute(Attribute $attribute, $value) { 
        
        $this->attributes[] = array('attribute' => $attribute, 'value' => $value);
        $this->attribute_values[] = $value;
        
        $this->session->set('filter_attributes', $this->attributes);
        $this->session->set('filter_attribute_values', $this->attribute_values);
        
        return $this->attributes;
    }
    
    public function removeAttribute(Attribute $attribute, $value) { 
        
        if(is_array($this->attributes)) { 
        
            $key = \array_search($value, $this->attributes);
            unset($this->attributes[$key]);
           
            $this->session->set('filter_attributes', $this->attributes);
        }
        
        if(is_array($this->attribute_values)) { 
            
            $key = \array_search($value, $this->attribute_values);
            unset($this->attribute_values[$key]);

            $this->session->set('filter_attribute_values', $this->attribute_values);
        }
        
        return $this->attributes;
    }
    
    public function clearFilter() { 
        
        $this->attributes = null;
        $this->session->set('filter_attributes', $this->attributes);
        
        $this->attribute_values = null;
        $this->session->set('filter_attribute_values', $this->attribute_values);

        $this->is_sale = null;
        $this->session->set('filter_is_sale', $this->is_sale);

        $this->orderby = 'DESC';
        $this->session->set('filter_orderby', $this->orderby);

        $this->sortby = 'NEWEST_FIRST';
        $this->session->set('filter_sortby', $this->sortby);

        $this->subcategory = null;
        $this->session->set('filter_subcategory', $this->subcategory);

        $this->maxResults = 15;
        $this->session->set('filter_max_results', $this->maxResults);
        
    }

    /*     * ******** Shortcuts to the service container etc. ********* */

    /**
     * Shortcut to return the Doctrine Registry service.
     *
     * @return Registry
     *
     * @throws \LogicException If DoctrineBundle is not available
     */
    private function getDoctrine() {
        if (!$this->container->has('doctrine')) {
            throw new \LogicException('The DoctrineBundle is not installed in your application.');
        }

        return $this->container->get('doctrine');
    }

    /**
     * Shortcut to return the request service.
     *
     * @return Request
     */
    private function getRequest() {
        return $this->container->get('request');
    }
}

?>
