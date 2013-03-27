<?php

namespace Ecommerce\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface; 

class EmailType extends AbstractType {

    private $email;

    public function __construct(\Ecommerce\EcommerceBundle\Entity\Email $email) {
        $this->email = $email;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
                // page Settings
                ->add('subject', 'text', array('label' => 'Onderwerp'))
                ->add('content', 'textarea', array('label' => 'Inhoud'))
                ;
    
    }
    
    public function getName() {
        return 'email';
    }

}