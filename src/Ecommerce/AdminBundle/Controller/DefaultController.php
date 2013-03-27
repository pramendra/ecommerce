<?php

namespace Ecommerce\AdminBundle00\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Ecommerce\AdminBundle00\Compile\GIFEncoder;


class DefaultController extends Controller
{

    public function indexAction()
    {
        $weekOrders = array();
        
        for($i = 0; $i < 10; $i++) { 
            $weekOrders[] = $this->getDoctrine()->getRepository('EcommerceBundle:Orders')->getOrdersCountByWeeks($i);
        }
        
        $weekOrders = array_reverse($weekOrders);
        
        $lastFiveOrders = $this->getDoctrine()->getRepository('EcommerceBundle:Orders')->findOrdersByMaxResults(11);
        
        $profit_prev_month = $this->getDoctrine()->getRepository('EcommerceBundle:Orders')->getProfitByMonth('previous');
        $profit_this_month = $this->getDoctrine()->getRepository('EcommerceBundle:Orders')->getProfitByMonth('this');
        
        $waitingForShipping = $this->getDoctrine()->getRepository('EcommerceBundle:Orders')->getOrdersWaitingForShpping(10);
        
        $newestProducts = $this->getDoctrine()->getRepository('EcommerceBundle:Product')->findLatestProducts(10);
        
        $mostViewedProducts = $this->getDoctrine()->getRepository('EcommerceBundle:Product')->findMostViewedProducts(5);
        
        
        return $this->render('AdminBundle00:Default:index.html.twig', 
                array('weekOrders' => $weekOrders, 'lastFiveOrders' => $lastFiveOrders, 'waitingForShipping' => $waitingForShipping,
                    'profit_this_month' => $profit_this_month, 'profit_prev_month' => $profit_prev_month,
                    'newestProducts' => $newestProducts, 'mostViewedProducts' => $mostViewedProducts));
    }

}
