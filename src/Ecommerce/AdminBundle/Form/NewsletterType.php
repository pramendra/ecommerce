<?php

namespace Ecommerce\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface; 

class NewsletterType extends AbstractType {

    private $newsletter;

    public function __construct(\Ecommerce\EcommerceBundle\Entity\Newsletter $newsletter) {
        $this->newsletter = $newsletter;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
                // page Settings
                ->add('title', 'text', array('label' => 'Onderwerp'))
                ->add('campainName', 'text', array('label' => 'Title (google)'))
                ->add('content', 'textarea', array('label' => 'Inhoud'))
                ;
    
    }
    
    public function getName() {
        return 'newsletter';
    }

}