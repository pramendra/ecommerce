<?php

namespace AddictedToVintage\EcommerceBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ShippingTypesRepository extends EntityRepository {
    
    public function getQueryBuilderProductShipping(\AddictedToVintage\EcommerceBundle\Entity\Product $product) {

        $qb = $this->createQueryBuilder('p');
        $qb->groupBy('p.id');
        $qb->orderBy('p.name');

        return $qb;
    }

}

?>