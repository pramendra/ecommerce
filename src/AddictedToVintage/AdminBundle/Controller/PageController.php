<?php

namespace AddictedToVintage\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use AddictedToVintage\EcommerceBundle\Entity\Page;

use Symfony\Component\HttpFoundation\Request;

class PageController extends Controller
{

    public function indexAction() {

        $pages = $this->getDoctrine()->getRepository('EcommerceBundle:Page')->findAll();
        
        return $this->render('AdminBundle:Page:index.html.twig', array('pages' => $pages));
    }

    public function editAction($id) {
        
        if($id == 0) { 
            $page = new Page();
        } else { 
            $page = $this->getDoctrine()->getRepository('EcommerceBundle:Page')->find($id);
        }

        $page_form = $this->createForm(new \AddictedToVintage\AdminBundle\Form\PageType($page), $page);

        $page_form->setData($page);

        if ($this->getRequest()->getMethod() == 'POST') {

            $page_form->bindRequest($this->getRequest());

            if ($page_form->isValid()) {
                
                $em = $this->getDoctrine()->getEntityManager();

                $request = Request::createFromGlobals();
                $postData = $request->request->get('page');
                
                if($page->getId() == null) {
                    $page->setCreatedAt(new \DateTime());                    
                    $em->persist($page);
                }
                
                $page->setUpdatedAt(new \DateTime());     

                $em->flush();

                return $this->redirect($this->generateUrl('admin_page', array('id' => $page->getId())));
            }
        }

        return $this->render('AdminBundle:Page:edit.html.twig', array('page' => $page,  'pages_form' => $page_form->createView()));
    }

}
