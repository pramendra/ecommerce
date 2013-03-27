<?php

namespace Ecommerce\AdminBundle00\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface; 

class CategoryType extends AbstractType {

    private $category;

    public function __construct(\Ecommerce\EcommerceBundle\Entity\Category $category) {
        $this->category = $category;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $category = $this->category;
        
        $builder
                // Category Settings
                ->add('name', 'text', array('label' => 'Naam'))
                ->add('description', 'textarea', array('label' => 'Omschrijving'))
                ->add('keywords', 'text', array('label' => 'Keywords'))
                ->add('active', 'choice', array('label' => 'Zichtbaar', 'choices'   => array('1' => 'Ja', '0' => 'Nee')))
                ->add('permalink', 'text', array('label' => 'Permalink')
                );
        
        //Brand settings
        $builder->add('sections', 'entity', array('class' => 'AddictedToVintage\\EcommerceBundle\Entity\\Section', 'multiple' => true, 'expanded' => true,
            'query_builder' => function (\Ecommerce\EcommerceBundle\Repository\SectionRepository $repository) use ($category) {
                return $repository->getQueryBuilderCategorySections($category);
         }));
        ;
    }

    public function getName() {
        return 'Category';
    }

}