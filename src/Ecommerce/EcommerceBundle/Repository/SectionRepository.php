<?php

namespace Ecommerce\EcommerceBundle\Repository;

use Doctrine\ORM\EntityRepository;

class SectionRepository extends EntityRepository {
    
    public function getQueryBuilderCategorySections(\Ecommerce\EcommerceBundle\Entity\Category $category) {

        $qb = $this->createQueryBuilder('p');
        $qb->groupBy('p.id');
        $qb->orderBy('p.name');

        return $qb;
    }

}

?>