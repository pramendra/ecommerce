<?php

namespace AddictedToVintage\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface; 

class PageType extends AbstractType {

    private $page;

    public function __construct(\BiologischeKaas\EcommerceBundle\Entity\Page $page) {
        $this->page = $page;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
                // page Settings
                ->add('title', 'text', array('label' => 'SEO Titel'))
                ->add('pagetitle', 'text', array('label' => 'Pagina Titel'))
                ->add('content', 'textarea', array('label' => 'Inhoud'))
                ->add('permalink', 'text', array('label' => 'Permalink'))
                ->add('description', 'text', array('label' => 'SEO Description'))
                ->add('keywords', 'text', array('label' => 'SEO Keywords'))
                ->add('landingpage', 'choice', array(
                        'choices'   => array(
                                '0'	=> 'Nee',
                                '1'	=> 'Ja'
                        ),
                        'multiple'  => false,
                ), array('label' => 'Landingpage'))
                ->add('landingpageKeyword', 'text', array('label' => 'Section | keyword'))
                ;
    
    }
    
    public function getName() {
        return 'page';
    }

}