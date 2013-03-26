<?php

namespace AddictedToVintage\EcommerceBundle\Repository;

use Doctrine\ORM\EntityRepository;

class CategoryRepository extends EntityRepository {

    public function getDistinctProductAttributes($products) {

        $attribute_values = array();

        foreach ($products as $product) {

            foreach ($product->getAttributes() as $product_attribute) {

                $attribute_values[$product_attribute->getAttribute()->getId()][ucfirst($product_attribute->getAttributeValue())] = ucfirst($product_attribute->getAttributeValue());
                array_unique($attribute_values[$product_attribute->getAttribute()->getId()]);
            }
        }

        return $attribute_values;
    }
    
     public function getQueryBuilderSubcategoryCategory(\AddictedToVintage\EcommerceBundle\Entity\Subcategory $subcategory) {

        $qb = $this->createQueryBuilder('p');
        $qb->groupBy('p.id');
        $qb->orderBy('p.name');

        return $qb;
    }
}