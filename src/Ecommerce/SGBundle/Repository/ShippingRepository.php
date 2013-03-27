<?php

namespace Ecommerce\SGBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ShippingRepository extends EntityRepository {
    
    public function getQueryBuilderProductShipping(\Ecommerce\SGBundle\Entity\Product $product) {

        $qb = $this->createQueryBuilder('p');
        $qb->groupBy('p.id');
        $qb->orderBy('p.name');

        return $qb;
    }

}

?>