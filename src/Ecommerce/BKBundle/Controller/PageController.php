<?php

namespace Ecommerce\BKBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PageController extends Controller {

    public function viewAction($permalink) {
        
        $page = $this->getDoctrine()->getRepository('BKBundle:Page')->findOneBy(array('permalink' => $permalink));
        
        if($page == null) { 
            return $this->forward('BKBundle:Product:shortcut', array('product' => $permalink));
        }
        
        return $this->render('BKBundle:Page:index.html.twig', array('page' => $page));

    }
    
   
	public function contactAction() {

		if ($this->getRequest()->getMethod() === 'POST') {

			$message = \Swift_Message::newInstance()
					->setSubject('Contact - Addictedtovintage.nl')
					->setReturnPath('info@addictedtovintage.nl')
					->setFrom('contact@addictedtovintage.nl')
					->setTo('info@addictedtovintage.nl')
					->setBody($this->renderView('BKBundle:Email:contact.txt.twig', array('vars' => $_POST)));
			$this->get('mailer')->send($message);


			return $this->render('BKBundle:Page:contact-send.html.twig');
		}

		return $this->render('BKBundle:Page:contact.html.twig');
	}


}
