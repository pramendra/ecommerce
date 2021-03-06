<?php

namespace Ecommerce\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class CategoryController extends Controller {

    public function indexAction() {

        $sections = $this->getDoctrine()->getRepository('EcommerceBundle:Section')->findAll();

        return $this->render('AdminBundle:Category:index.html.twig', array('sections' => $sections));
    }

    public function deleteSubcategoryAction($id) {
        
        $subcategory = $this->getDoctrine()->getRepository('EcommerceBundle:Subcategory')->find($id);
        
        $em = $this->getDoctrine()->getEntityManager();
        $em->remove($subcategory);
        
        $em->flush();
        
        return $this->redirect($this->generateUrl('admin_category'));
    }

    public function deleteAction($id) {
        
        $category = $this->getDoctrine()->getRepository('EcommerceBundle:Category')->find($id);
        
        $em = $this->getDoctrine()->getEntityManager();
        $em->remove($category);
        
        $em->flush();
        
        return $this->redirect($this->generateUrl('admin_category'));
    }

    public function editAction($id) {

        if ($id == 0) {
            $category = new \Ecommerce\EcommerceBundle\Entity\Category();
        } else {
            $category = $this->getDoctrine()->getRepository('EcommerceBundle:Category')->find($id);
        }

        $category_form = $this->createForm(new \Ecommerce\AdminBundle\Form\CategoryType($category), $category);

        $category_form->setData($category);

        if ($this->getRequest()->getMethod() == 'POST') {

            $category_form->bindRequest($this->getRequest());

            if ($category_form->isValid()) {

                $em = $this->getDoctrine()->getEntityManager();

                $request = Request::createFromGlobals();
                $postData = $request->request->get('category');

                if ($category->getId() == null) {
                    $em->persist($category);
                }

                $em->flush();

                return $this->redirect($this->generateUrl('admin_category_edit', array('id' => $category->getId())));
            }
        }

        return $this->render('AdminBundle:Category:edit.html.twig', array('category' => $category, 'category_form' => $category_form->createView()));
    }

    public function editSubcategoryAction($id) {

        if ($id == 0) {
            $subcategory = new \Ecommerce\EcommerceBundle\Entity\Subcategory();
        } else {
            $subcategory = $this->getDoctrine()->getRepository('EcommerceBundle:Subcategory')->find($id);
        }

        $subcategory_form = $this->createForm(new \Ecommerce\AdminBundle\Form\SubcategoryType($subcategory), $subcategory);

        $subcategory_form->setData($subcategory);

        if ($this->getRequest()->getMethod() == 'POST') {

            $subcategory_form->bindRequest($this->getRequest());

            if ($subcategory_form->isValid()) {

                $em = $this->getDoctrine()->getEntityManager();

                $request = Request::createFromGlobals();
                $postData = $request->request->get('category');

                if ($subcategory->getId() == null) {
                    $em->persist($subcategory);
                }

                $em->flush();

                return $this->redirect($this->generateUrl('admin_subcategory_edit', array('id' => $subcategory->getId())));
            }
        }

        return $this->render('AdminBundle:Subcategory:edit.html.twig', array('subcategory' => $subcategory, 'subcategory_form' => $subcategory_form->createView()));
    }

}
