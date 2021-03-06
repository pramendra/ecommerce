<?php

namespace Ecommerce\EcommerceBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ShippingTypesRepository extends EntityRepository {
    
    public function getQueryBuilderProductShipping(\Ecommerce\EcommerceBundle\Entity\Product $product) {

        $qb = $this->createQueryBuilder('p');
        $qb->groupBy('p.id');
        $qb->orderBy('p.name');

        return $qb;
    }

}

?>