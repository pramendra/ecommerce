<?php

namespace Ecommerce\SGBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PageController extends Controller {

    public function viewAction($permalink) {
        
        $page = $this->getDoctrine()->getRepository('SGBundle:Page')->findOneBy(array('permalink' => $permalink));
        
        if($page == null) { 
            return $this->forward('SGBundle:Product:shortcut', array('product' => $permalink));
        }
        
        return $this->render('SGBundle:Page:index.html.twig', array('page' => $page));

    }
    
   
	public function contactAction() {

		if ($this->getRequest()->getMethod() === 'POST') {

			$message = \Swift_Message::newInstance()
					->setSubject('Contact - Addictedtovintage.nl')
					->setReturnPath('info@addictedtovintage.nl')
					->setFrom('contact@addictedtovintage.nl')
					->setTo('info@addictedtovintage.nl')
					->setBody($this->renderView('SGBundle:Email:contact.txt.twig', array('vars' => $_POST)));
			$this->get('mailer')->send($message);


			return $this->render('SGBundle:Page:contact-send.html.twig');
		}

		return $this->render('SGBundle:Page:contact.html.twig');
	}


}
