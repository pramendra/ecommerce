<?php

namespace Ecommerce\EcommerceBundle\Repository;

use Doctrine\ORM\EntityRepository;

class SubcategoryRepository extends EntityRepository {

    public function getActiveSubcategoriesByCategory(\Ecommerce\EcommerceBundle\Entity\Category $category) {
        
        $qb = $this->createQueryBuilder('sc');

        $qb->innerJoin('sc.categories', 'scc');
        $qb->where('scc = :category');
        $qb->setParameter('category', $category);
        
        $qb->andWhere('sc.active = 1');
                
        return $qb->getQuery()->getResult();
    }

    public function getQueryBuilderProductSubcategories(\Ecommerce\EcommerceBundle\Entity\Product $product) {

        $qb = $this->createQueryBuilder('p');
        $qb->groupBy('p.id');
        $qb->orderBy('p.name');

        return $qb;
    }

}

?>