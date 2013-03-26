<?php

namespace AddictedToVintage\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ProductType extends AbstractType {

    private $product;

    public function __construct(\AddictedToVintage\EcommerceBundle\Entity\Product $product) {
        $this->product = $product;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $product = $this->product;

        $builder
                //hidden field for anchor
                ->add('anchor', 'hidden', array("property_path" => false))

                // Account Settings
                ->add('name', 'text', array('label' => 'Naam'))
                ->add('description', 'textarea', array('label' => 'Omschrijving'))
                ->add('sku', 'text', array('label' => 'SKU'))
                //->add('keywords', 'text', array('label' => 'META Keywords'))
                //->add('salePrice', 'text', array('label' => 'Inkoopsprijs'))
                ->add('price', 'text', array('label' => 'Prijs'))
                //->add('permalink', 'text', array('label' => 'Permalink'))
                ->add('stock', 'choice', array(
                    'choices' => array(
                        '0' => '0',
                        '1' => '1',
                        '2' => '2',
                        '3' => '3',
                        '4' => '4',
                        '5' => '5',
                        '6' => '6',
                        '7' => '7',
                        '8' => '8',
                        '9' => '9',
                        '10' => '10'
                    ),
                    'label' => 'Voorraad',
                    'multiple' => false,
                ))
                ->add('isNew', 'checkbox', array(
                    'label' => 'Nieuw',
                    'required' => false,
                ))
                ->add('isSale', 'checkbox', array(
                    'label' => 'Sale',
                    'required' => false,
                ))
               ->add('active', 'choice', array(
                    'choices' => array(
                        '0' => 'Nee',
                        '1' => 'Ja'
                    ),
                    'label' => 'Actief',
                    'multiple' => false,
                ))

        ;
        
        $builder->add('subcategories', 'entity', array('class' => 'AddictedToVintage\\EcommerceBundle\Entity\\Subcategory', 'multiple' => true, 'expanded' => true,
            'query_builder' => function (\AddictedToVintage\EcommerceBundle\Repository\SubcategoryRepository $repository) use ($product) {
                return $repository->getQueryBuilderProductSubcategories($product)
                ;
            }));
        
        $builder->add('shippingType', 'entity', array('class' => 'AddictedToVintage\\EcommerceBundle\Entity\\ShippingTypes', 'multiple' => false, 'expanded' => false, 'label' => 'Verzendwijze',
            'query_builder' => function (\AddictedToVintage\EcommerceBundle\Repository\ShippingTypesRepository $repository) use ($product) {
                return $repository->getQueryBuilderProductShipping($product)
                ;
            }));
       ;
    }

    public function getName() {
        return 'product';
    }

}