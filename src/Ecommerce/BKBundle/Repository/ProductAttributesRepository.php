<?php

namespace Ecommerce\BKBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ProductAttributesRepository extends EntityRepository {

    public function findbyAttributeLike($like) {

        $sql = "SELECT pa FROM BKBundle:ProductAttributes pa WHERE pa.attributeValue LIKE '".$like."'";

        return $this->getEntityManager()->createQuery($sql)->getResult();
    }

}