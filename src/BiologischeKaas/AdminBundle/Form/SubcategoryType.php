<?php

namespace AddictedToVintage\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface; 

class SubcategoryType extends AbstractType {

    private $subcategory;

    public function __construct(\BiologischeKaas\EcommerceBundle\Entity\Subcategory $subcategory) {
        $this->subcategory = $subcategory;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $subcategory = $this->subcategory;
        
        $builder
                // Category Settings
                ->add('name', 'text', array('label' => 'Naam'))
                ->add('description', 'textarea', array('label' => 'Omschrijving'))
                ->add('keywords', 'text', array('label' => 'Keywords'))
                ->add('permalink', 'text', array('label' => 'Permalink'))
                ->add('active', 'choice', array('label' => 'Zichtbaar', 'choices'   => array('1' => 'Ja', '0' => 'Nee'))
                );
        
         //Brand settings
        $builder->add('categories', 'entity', array('class' => 'AddictedToVintage\\EcommerceBundle\Entity\\Category', 'multiple' => true, 'expanded' => false,
            'query_builder' => function (\BiologischeKaas\EcommerceBundle\Repository\CategoryRepository $repository) use ($subcategory) {
                return $repository->getQueryBuilderSubcategoryCategory($subcategory);
         }));
        ;
    }

    public function getName() {
        return 'Subcategory';
    }

}