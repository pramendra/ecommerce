<?php

namespace AddictedToVintage\EcommerceBundle\Twig\Extension;

class DayConvertTwigExtension extends \Twig_Extension {

    function __construct() { }

    public function getFilters() {
        return array(
            'DayConvert' => new \Twig_Filter_Method($this, 'DayConvert'),
        );
    }

    public function DayConvert($day) {
       
        switch($day) { 
            case "Mon" :
                return 'Maandag';
                break;
            case "Tue" :
                return 'Dinsdag';
                break;
            case "Wed" :
                return 'Woensdag';
                break;
            case "Thu" :
                return 'Donderdag';
                break;
            case "Fri" :
                return 'Vrijdag';
                break;
            case "Sat" :
                return 'Zaterdag';
                break;
            case "Sun" :
                return 'Zondag';
                break;
        }
    }

    public function getName() {
        return 'DayConvert_twig_extension';
    }

}