<?php

namespace Ecommerce\AddictedtovintageBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Ecommerce\AddictedtovintageBundle\Entity\Subcategory;
use Ecommerce\AddictedtovintageBundle\Entity\Product;
use Ecommerce\AddictedtovintageBundle\Entity\ProductAttributes;

class ProductRepository extends EntityRepository {

    public function getProductAttributes($products, $attribute) {
        $query = "SELECT pa
        		FROM AddictedtovintageBundle:ProductAttributes pa 
        		WHERE pa.product IN ( " . $products . " )
        		AND pa.attribute = '" . $attribute . "'
        		GROUP BY pa.attributeValue ";

        return $this->getEntityManager()->createQuery($query)->getResult();
    }
    public function findLatestProducts($maxResults) { 
        
        $qb = $this->createQueryBuilder('p');
                
        $qb->where("p.deletedAt IS NULL");
        $qb->andWhere('p.stock > 0');
        $qb->andWhere('p.active = 1');
        
        $qb->orderBy('p.createdAt', 'DESC');
        $qb->setMaxResults($maxResults);
        
        return $qb->getQuery()->getResult();
    }
    
    public function findProductsBySectionAndKeyword($section, $keyword, $maxResults = 20) { 
        
        $qb = $this->createQueryBuilder('p');
                
        $qb->where("p.deletedAt IS NULL");
        $qb->andWhere('p.stock > 0');
        $qb->andWhere('p.active = 1');
        
        $qb->innerJoin('p.attributes', 'pa');
        
        $qb->andWhere('pa.attributeValue LIKE :attribute');
	$qb->setParameter('attribute', '%' . $keyword . '%');
	
//        $qb->orWhere('p.description LIKE :keyword');
//        $qb->setParameter('keyword', '%'. $keyword . '%');
        
        $qb->innerJoin('p.subcategories', 'psub');
        $qb->innerJoin('psub.categories', 'pcat');
        $qb->leftJoin('pcat.sections', 'sec');
        
        $qb->andWhere('sec.id = :section');
        $qb->setParameter('section', $section->getId());   
        
        $qb->orderBy('p.createdAt', 'DESC');
        $qb->setMaxResults($maxResults);
        
        return $qb->getQuery()->getResult();
        
    }
    
    public function findActiveProductByPermalink($permalink) { 
        
        $qb = $this->createQueryBuilder('p');
                
        $qb->where("p.permalink = :permalink");
        $qb->setParameter("permalink", $permalink);
        
        $qb->andWhere("p.deletedAt IS NULL");
        $qb->andWhere('p.stock > 0');
        $qb->andWhere('p.active = 1');
        
        $qb->orderBy('p.createdAt', 'DESC');
        $qb->setMaxResults(1);
        
        return $qb->getQuery()->getResult();
        
    }
    
    public function findMostViewedProducts($maxResults) { 
        
        $qb = $this->createQueryBuilder('p');
                
        $qb->where("p.deletedAt IS NULL");
        $qb->andWhere('p.stock > 0');
        $qb->andWhere('p.active = 1');
        
        $qb->orderBy('p.views', 'DESC');
        $qb->setMaxResults($maxResults);
        
        return $qb->getQuery()->getResult();
    }
    
    public function findRelatedProductsByAttribute(Subcategory $subcategory, ProductAttributes $attribute, $maxResults = 5, Product $product) { 
        
        $qb = $this->createQueryBuilder('p');
        $qb->innerJoin('p.attributes', 'pa');
        
        $qb->where('pa.attributeValue = :attribute');
        $qb->setParameter('attribute', $attribute->getAttributeValue());
        
        $qb->innerJoin('p.subcategories', 'ps');
        
        $qb->andWhere('ps.id = :subcategory');
        $qb->setParameter('subcategory', $subcategory->getId());
                
        $qb->andWhere('p.stock > 0');
        
        $qb->andWhere('p.id != :product');
        $qb->setParameter('product', $product->getId());
        
        $qb->setMaxResults($maxResults);
        
        return $qb->getQuery()->getResult();
    }
    
    public function findLatestProductsBySection(\Ecommerce\AddictedtovintageBundle\Entity\Section $section, $maxResults = 99999) { 
        
        $qb = $this->createQueryBuilder('p');
        
        $qb->where("p.deletedAt IS NULL");
        $qb->andWhere('p.stock > 0');
        $qb->andWhere('p.active = 1');

        $qb->innerJoin('p.subcategories', 'psub');
        $qb->innerJoin('psub.categories', 'pcat');
        $qb->leftJoin('pcat.sections', 'sec');
        
        $qb->andWhere('sec.id = :section');
        $qb->setParameter('section', $section->getId());        
        
        $qb->orderBy('p.createdAt', 'DESC');
        $qb->setMaxResults($maxResults);
        
        return $qb->getQuery()->getResult();
    }
    
    public function findLatestProductsByCategory(\Ecommerce\AddictedtovintageBundle\Entity\Category $category, $maxResults = 5) { 
        
        $qb = $this->createQueryBuilder('p');
                
        $qb->leftJoin('p.subcategories', 'psub');
        $qb->leftJoin('psub.categories', 'pcat');
        
        $qb->where('pcat.id = :category');
        $qb->setParameter('category', $category->getId());
        
        $qb->andWhere("p.deletedAt IS NULL");
        $qb->andWhere('p.stock > 0');
        $qb->andWhere('p.active = 1');
        
        $qb->orderBy('p.createdAt', 'DESC');
        $qb->setMaxResults($maxResults);
        
        return $qb->getQuery()->getResult();
    }
    
    public function findAllProductsByCategory(\Ecommerce\AddictedtovintageBundle\Entity\Category $category) { 
        
        $qb = $this->createQueryBuilder('p');
                
        $qb->leftJoin('p.subcategories', 'psub');
        $qb->leftJoin('psub.categories', 'pcat');
        
        $qb->where('pcat = :category');
        $qb->setParameter('category', $category->getId());
        
        $qb->andWhere("p.deletedAt IS NULL");
        $qb->andWhere('p.stock > 0');
        $qb->andWhere('p.active = 1');
        
        $qb->orderBy('p.createdAt', 'DESC');
        
        return $qb->getQuery()->getResult();
        #die($qb->getQuery()->getSQL());
    }

    public function findByOffsetAndFilter($firstResult, $productFilter) {

        $qb = $this->createQueryBuilder('p');

        if($productFilter->getSubcategory() !== null) {
            
            if($productFilter->getSubcategory()->getActive() == 1) { 
                $qb->innerJoin('p.subcategories', 'sb');
                $qb->where('sb = :subcategory');
                $qb->setParameter('subcategory', $productFilter->getSubcategory());
            }
        }

        if($productFilter->getCategory() !== null) { 
            
            if($productFilter->getCategory()->getActive() == 1) { 
                $qb->leftJoin('p.subcategories', 'psub');
                $qb->leftJoin('psub.categories', 'pcat');

                $qb->where('pcat = :category');
                $qb->setParameter('category', $productFilter->getCategory()->getId());
            }
        }
        
        if($productFilter->getSection() !== null) { 
            
            $qb->leftJoin('p.subcategories', 'psub');
            $qb->leftJoin('psub.categories', 'pcat');
            $qb->leftJoin('pcat.sections', 'psec');

            $qb->where('psec = :section');
            $qb->setParameter('section', $productFilter->getSection()->getId());
        }
        
        $qb->groupBy('p.id');
        
        $qb->setFirstResult($firstResult);
        $qb->setMaxResults($productFilter->getMaxResults());
        
        $qb->andWhere('p.stock > 0');
        $qb->andWhere('p.active = 1');
        
        /* ATTRIBUTES */
        
        if($productFilter->getAttributes() != null) { 
            
            $i = 0;
            
            foreach($productFilter->getAttributes() as $filter_attribute) { 
            
                $qb->innerJoin('p.attributes', 'pa' . $i);
                
                $attribute = $filter_attribute['attribute'];
                $attribute_value = $filter_attribute['value'];
                
                $qb->andWhere('pa' . $i. '.attribute = :attribute' . $i);
                $qb->setParameter('attribute' . $i, $attribute->getId());
                
                $qb->andWhere('pa' . $i. '.attributeValue = :attribute_value' . $i);
                $qb->setParameter('attribute_value' . $i, $attribute_value);
                
                $i++;
                
            }
        }
        
        /* SET SALE ITEMS */
        
        if($productFilter->getIsSale() == true) { 
            $qb->andWhere('p.isSale = 1');
        }
        
        /* ORDER BY */ 
        
        switch($productFilter->getSortBy()) { 
            
            case "NEWEST_FIRST" : 
                    $qb->orderBy('p.id', $productFilter->getOrderBy());
                break;
            
            case "PRICE_HIGH_LOW" : 
                    $qb->orderBy('p.price', 'DESC');
                break;
            
            case "PRICE_LOW_HIGH" : 
                    $qb->orderBy('p.price', 'ASC');
                break;
            
            case "NAME_A_Z" : 
                    $qb->orderBy('p.name', 'ASC');
                break;
            
            case "NAME_Z_A" : 
                    $qb->orderBy('p.name', 'DESC');
                break;
            
        }
        
        $qb->andWhere("p.deletedAt IS NULL");
        
        //die ( $qb->getQuery()->getSQL() );
        
        return $qb->getQuery()->getResult();
    }
    
    public function searchProductsByKeyword($q, $firstResult = 0, $maxResults = 100) { 
        
        $qb = $this->createQueryBuilder('p');

        
        $qb->innerJoin('p.subcategories', 'sb');
        $qb->where('sb IS NOT NULL');
        
        $qb->andWhere("p.name LIKE :q");
        $qb->orWhere("p.description LIKE :q");
        
        $qb->setParameter(':q', '%' . $q . '%');
        
        $qb->andWhere('p.stock > 0');
        $qb->andWhere("p.deletedAt IS NULL");
        $qb->andWhere('p.active = 1');
        
        $qb->groupBy('p.id');
        
        $qb->setFirstResult($firstResult);
        $qb->setMaxResults($maxResults);
        
        return $qb->getQuery()->getResult();
        
    }
    
    public function findProductsByAdminFilter($stock, $subcategory, $sale) { 
        
        $qb = $this->createQueryBuilder('p');

        if($stock == 1) { 
            $qb->andWhere("p.stock = 0");
        }
        
        if($stock == 2) { 
           $qb->andWhere("p.stock > 0");
        }
        
        if($sale == 1) { 
           $qb->andWhere("p.isSale = 1");
        }
        
        $qb->andWhere("p.deletedAt IS NULL");
        
        if($subcategory != null) { 
            
            $qb->leftJoin('p.subcategories', 'sb');
            $qb->where('sb.id = :subcategory');
            $qb->setParameter('subcategory', $subcategory->getId());
        }
        
        return $qb->getQuery()->getResult();
        
    }

    public function getCountBySubcategory(Subcategory $subcategory) {

        $qb = $this->createQueryBuilder('p');
        $qb->andWhere('p.stock > 0');
        $qb->andWhere("p.deletedAt IS NULL");
        $qb->andWhere('p.active = 1');

        $qb->leftJoin('p.subcategories', 'sb');
        $qb->where('sb.id = :subcategory');
        $qb->setParameter('subcategory', $subcategory->getId());
        
        $qb->select('count(p.id)');

        return $qb->getQuery()->getSingleScalarResult();
    }

    public function getActiveProductsBySubcategory(Subcategory $subcategory, $maxResults = null) {

        $qb = $this->createQueryBuilder('p');
        
        $qb->leftJoin('p.subcategories', 'sb');
        $qb->where('sb.id = :subcategory');
        $qb->setParameter('subcategory', $subcategory->getId());
                
        $qb->andWhere('p.stock > 0');
        $qb->andWhere("p.deletedAt IS NULL");
        $qb->andWhere('p.active = 1');
                
        if($maxResults != null) { 
            $qb->setMaxResults($maxResults);
        }
        
        $qb->orderBy('p.createdAt', 'DESC');
                
        return $qb->getQuery()->getResult();
    }

}

?>