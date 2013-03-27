<?php

namespace Ecommerce\AdminBundle00\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ecommerce\EcommerceBundle\Entity\Page;

use Symfony\Component\HttpFoundation\Request;

class NewsletterController extends Controller
{

    public function indexAction() {

        $newsletters = $this->getDoctrine()->getRepository('EcommerceBundle:Newsletter')->findAll();
        
        return $this->render('AdminBundle00:Newsletter:index.html.twig', array('newsletters' => $newsletters));
    }

    public function editAction($id) {
        
        if($id == 0) { 
            $newsletter = new \Ecommerce\EcommerceBundle\Entity\Newsletter();
        } else { 
            $newsletter = $this->getDoctrine()->getRepository('EcommerceBundle:Newsletter')->find($id);
        }

        $newsletter_form = $this->createForm(new \Ecommerce\AdminBundle00\Form\NewsletterType($newsletter), $newsletter);

        $newsletter_form->setData($newsletter);

        if ($this->getRequest()->getMethod() == 'POST') {

            $newsletter_form->bindRequest($this->getRequest());

            if ($newsletter_form->isValid()) {
                
                $em = $this->getDoctrine()->getEntityManager();

                $request = Request::createFromGlobals();
                $postData = $request->request->get('page');
                
                if($newsletter->getId() == null) {
                    $newsletter->setCreatedAt(new \DateTime());                    
                    $em->persist($newsletter);
                }

                $em->flush();

                return $this->redirect($this->generateUrl('admin_newsletter', array('id' => $newsletter->getId())));
            }
        }

        return $this->render('AdminBundle00:Newsletter:edit.html.twig', array('newsletter' => $newsletter, 'newsletter_form' => $newsletter_form->createView()));
    }

}
