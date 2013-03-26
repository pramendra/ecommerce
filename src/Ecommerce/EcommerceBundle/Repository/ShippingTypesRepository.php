<?php

namespace Ecommerce\BiologischekaasBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ShippingTypesRepository extends EntityRepository {
    
    public function getQueryBuilderProductShipping(\Ecommerce\BiologischekaasBundle\Entity\Product $product) {

        $qb = $this->createQueryBuilder('p');
        $qb->groupBy('p.id');
        $qb->orderBy('p.name');

        return $qb;
    }

}

?>