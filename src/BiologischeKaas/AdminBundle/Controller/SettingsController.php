<?php

namespace BiologischeKaas\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use BiologischeKaas\EcommerceBundle\Entity\Coupon;

class SettingsController extends Controller {

    public function emailAction() {

        $email = $this->getDoctrine()->getRepository('EcommerceBundle:Email')->findAll();
        
        return $this->render('AdminBundle:Email:index.html.twig', array('emails' => $email));
    }

    public function viewEmailAction($id) {

        $email = $this->getDoctrine()->getRepository('EcommerceBundle:Email')->find($id);
        
        return $this->render('AdminBundle:Email:view.html.twig', array('email' => $email));
    }

    public function couponsAction() {

        $coupons = $this->getDoctrine()->getRepository('EcommerceBundle:Coupon')->findAll();
        
        return $this->render('AdminBundle:Coupons:index.html.twig', array('coupons' => $coupons));
    }

    public function viewCouponAction($id) {
        
        if($id == 0) { 
            $coupon = new Coupon();
        } else { 
            $coupon = $this->getDoctrine()->getRepository('EcommerceBundle:Coupon')->find($id);
        }

        $coupon_form = $this->createForm(new \BiologischeKaas\AdminBundle\Form\CouponType($coupon), $coupon);

        $coupon_form->setData($coupon);

        if ($this->getRequest()->getMethod() == 'POST') {

            $coupon_form->bindRequest($this->getRequest());

            if ($coupon_form->isValid()) {
                
                $em = $this->getDoctrine()->getEntityManager();

                $request = Request::createFromGlobals();
                $postData = $request->request->get('coupon');
                
                if($coupon->getId() == null) {
                    $coupon->setCreatedAt(new \DateTime());                    
                    $em->persist($coupon);
                }

                $em->flush();

                return $this->redirect($this->generateUrl('admin_coupon', array('id' => $coupon->getId())));
            }
        }
        
        $orders = $this->getDoctrine()->getRepository('EcommerceBundle:Orders')->findBy(array('coupon' => $coupon->getId()));

        return $this->render('AdminBundle:Coupons:edit.html.twig', array('coupon' => $coupon, 'orders' => $orders, 'coupons_form' => $coupon_form->createView()));
    }
}
