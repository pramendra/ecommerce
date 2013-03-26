<?php

namespace AddictedToVintage\EcommerceBundle\Twig\Extension;

class FirstImageTwigExtension extends \Twig_Extension {

    function __construct() { }

    public function getFilters() {
        return array(
            'getFirstImage' => new \Twig_Filter_Method($this, 'getFirstImage'),
        );
    }

    public function getFirstImage($product) {
       
        print_r($product);
        
        return $product;
    }

    public function getName() {
        return 'getFirstImage_twig_extension';
    }

}