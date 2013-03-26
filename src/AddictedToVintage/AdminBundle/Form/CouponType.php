<?php

namespace AddictedToVintage\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface; 

class CouponType extends AbstractType {

    private $coupon;

    public function __construct(\AddictedToVintage\EcommerceBundle\Entity\Coupon $coupon) {
        $this->coupon = $coupon;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
                // Coupon Settings
                ->add('code', 'text', array('label' => 'Code'))
                ->add('discount', 'text', array('label' => 'Korting'))
                ->add('discountType', 'choice', array(
                        'choices'   => array(
                                '1'   => 'Percentage',
                                '2' => 'Bedrag'
                        ),
                        'multiple'  => false,
                ));

    }

    public function getName() {
        return 'Coupon';
    }

}