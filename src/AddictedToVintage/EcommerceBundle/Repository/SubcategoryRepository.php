<?php

namespace AddictedToVintage\EcommerceBundle\Repository;

use Doctrine\ORM\EntityRepository;

class SubcategoryRepository extends EntityRepository {

    public function getActiveSubcategoriesByCategory(\AddictedToVintage\EcommerceBundle\Entity\Category $category) {
        
        $qb = $this->createQueryBuilder('sc');

        $qb->innerJoin('sc.categories', 'scc');
        $qb->where('scc = :category');
        $qb->setParameter('category', $category);
        
        $qb->andWhere('sc.active = 1');
                
        return $qb->getQuery()->getResult();
    }

    public function getQueryBuilderProductSubcategories(\AddictedToVintage\EcommerceBundle\Entity\Product $product) {

        $qb = $this->createQueryBuilder('p');
        $qb->groupBy('p.id');
        $qb->orderBy('p.name');

        return $qb;
    }

}

?>