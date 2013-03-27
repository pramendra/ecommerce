<?php

namespace Ecommerce\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface; 

class ClientType extends AbstractType {

    private $client;

    public function __construct(\Ecommerce\EcommerceBundle\Entity\Client $client) {
        $this->client = $client;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $client = $this->client;

        $builder
                //hidden field for anchor
                ->add('anchor', 'hidden', array("property_path" => false))

                // Account Settings
                ->add('name', 'text', array('label' => 'Naam'))
                ->add('address', 'text', array('label' => 'Adres'))
                ->add('zipcode', 'text', array('label' => 'Postcode'))
                ->add('location', 'text', array('label' => 'Woonplaats'))
                ->add('country', 'text', array('label' => 'Land'))
                ->add('phone', 'text', array('label' => 'Telefoonnnummer'))
                ->add('email', 'text', array('label' => 'E-mailadres'))
                ->add('shippingAddress', 'text', array('label' => 'Adres'))
                ->add('shippingZipcode', 'text', array('label' => 'Postcode'))
                ->add('shippingLocation', 'text', array('label' => 'Woonplaats'))
                ->add('shippingCountry', 'text', array('label' => 'Land'))
                ->add('password', 'repeated', array(
                    'type' => 'password',
                    'invalid_message' => 'De gegeven wachtwoorden moeten overeenkomen.',
                    'options' => array('label' => 'Password'),
                    'required' => false,
                    'attr' => array('class' => 'pass')
                ))
                ;
/*        //Brand settings
        $builder->add('memberSibbenBrandsFilter', 'entity', array('class' => 'Sibben\\AZBundle\Entity\\SibbenBrands', 'multiple' => true, 'expanded' => true,
            'query_builder' => function (\Sibben\AZBundle\Repository\SibbenBrandsRepository $repository) use ($member) {
                return $repository->getQueryBuilderSubscripedSibbenBrands($member)
                ;
            })); 

        ; */
    }

    public function getName() {
        return 'Client';
    }

}