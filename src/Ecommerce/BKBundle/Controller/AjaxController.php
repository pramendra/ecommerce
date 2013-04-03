<?php

namespace Ecommerce\BKBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Ecommerce\EcommerceBundle\Entity\Product;
use Ecommerce\EcommerceBundle\Entity\Cart;
use Ecommerce\EcommerceBundle\Entity\CartProducts;
use Ecommerce\EcommerceBundle\ProductFilter\ProductFilter;

class AjaxController extends Controller {

    public function indexAction() {
        
        $result = '';

        if ($this->getRequest()->getMethod() === 'POST') {

            $post_action = $this->get('request')->request->get('post_action');

            switch ($post_action) {

                case "add_to_cart":
                    $result = $this->add_to_cart();
                    break;

                case "set_shipping_method":
                    $result = $this->set_shipping_method();
                    break;

                case "add_to_list":
                    $result = $this->add_to_list();
                    break;

                case "remove_from_cart":
                    $result = $this->remove_from_cart();
                    break;

                case "add_coupon":
                    $result = $this->add_coupon();
                    break;

                case "clear_coupon":
                    $result = $this->clear_coupon();
                    break;

                case "set_filter":
                    $result = $this->set_product_filter();
                    break;

                case "set_sort_by":
                    $result = $this->set_sort_by();
                    break;

                case "set_sale_only":
                    $result = $this->set_sale_only();
                    break;

                case "set_max_results":
                    $result = $this->set_max_results();
                    break;

                case "reset_filter":
                    $result = $this->reset_filter();
                    break;

                default:
                    throw $this->createNotFoundException('post_action does not exists : "' . $post_action . '"');
                    break;
            }
        }

        $response = new Response(json_encode($result));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    private function remove_from_cart() {

        $shopManager = $this->get('ShopManager');
        
        $product = $this->getDoctrine()->getRepository('EcommerceBundle:Product')->find($this->getRequest()->get('product'));
        
        $shopManager->removeProductFromCart($product);
        
        $shopManager->setDebugMode(false);
        
        $cart = $shopManager->getCart();
        
        return array('product' => $product->__toJson(), 'cart' => $cart->__toJson(), 'debug' => $shopManager->getDebug());
    }

    private function add_to_cart() {

        $product_id = $this->get('request')->request->get('product');
        $amount = $this->get('request')->request->get('amount');

        $product = $this->getDoctrine()
                ->getRepository('EcommerceBundle:Product')
                ->findOneById($product_id);

        $shopManager = $this->get('ShopManager');

        $shopManager->setDebugMode(false);

        $shopManager->addProductToCart($product, $amount);

        $cart = $shopManager->getCart();
        
        return array('product' => $product->__toJson(), 'cart' => $cart->__toJson(), 'debug' => $shopManager->getDebug());
    }

    private function add_to_list() {

        $product_id = $this->get('request')->request->get('product');

        $product = $this->getDoctrine()
                ->getRepository('EcommerceBundle:Product')
                ->findOneById($product_id);

        $shopManager = $this->get('ShopManager');

        $shopManager->setDebugMode(false);

        $shopManager->addToShoppingList($product);

        $list = $shopManager->getShoppingList();

        return array('product' => $product->__toJson(), 'list' => $list);
    }

    private function add_coupon() {

        $discount = 0;

        $code = $this->get('request')->request->get('code');

        $shopManager = $this->get('ShopManager');

        if ($shopManager->addCouponCode($code)) {
            $discount = number_format($shopManager->getDiscount(), 2, ',', '.');
        }

        $shopManager->setDebugMode(false);

        $cart = $shopManager->getCart();

        return array('cart' => $cart->__toJson(), 'discount' => $discount, 'debug' => $shopManager->getDebug());
    }

    private function clear_coupon() {

        $discount = 0;

        $shopManager = $this->get('ShopManager');

        $shopManager->clearCouponCode();
        $shopManager->setDebugMode(false);

        $cart = $shopManager->getCart();

        return array('cart' => $cart->__toJson(), 'discount' => $discount, 'debug' => $shopManager->getDebug());
    }

    private function set_shipping_method() {

        $shipping = $this->get('request')->request->get('shipping');

        $shopManager = $this->get('ShopManager');

        $shopManager->setShipping($shipping);
        
        $shopManager->setDebugMode(false);
        
        $cart = $shopManager->getCart();
        
        return array('cart' => $cart->__toJson(), 'debug' => $shopManager->getDebug());
    }

    private function set_product_filter() {

        $productFilter = $this->get('ProductFilter');

        $result = '';
        
        $attribute_id = $this->get('request')->request->get('attribute');
        $attribute = $this->getDoctrine()->getRepository('EcommerceBundle:Attribute')->find($attribute_id);

        $attribute_value = $this->get('request')->request->get('attribute_value');

        if ($this->get('request')->request->get('action') == 'add') { // add to filter
            $productFilter->addAttribute($attribute, $attribute_value);
        }

        if ($this->get('request')->request->get('action') == 'remove') { // remove from filter
            $productFilter->removeAttribute($attribute, $attribute_value);
        }
        
        foreach($productFilter->getAttributes() as $attr ) { 
            $result[] = $attr;
        }
        
        return $result;
    }
    
    private function set_sort_by() {

        $productFilter = $this->get('ProductFilter');

        return $productFilter->setSortBy($this->get('request')->request->get('sort_by'));
    }
    
    private function set_sale_only() {

        $productFilter = $this->get('ProductFilter');

        if($this->get('request')->request->get('is_sale') === 'true') { 
            return $productFilter->setIsSale(true);
        } else { 
            return $productFilter->setIsSale(false);
        }
    }
    
    private function set_max_results() {

        $productFilter = $this->get('ProductFilter');

        return $productFilter->setMaxResults($this->get('request')->request->get('max_results'));
    }
    
    private function reset_filter() {

        $productFilter = $this->get('ProductFilter');

        return $productFilter->clearFilter();
    }

}
