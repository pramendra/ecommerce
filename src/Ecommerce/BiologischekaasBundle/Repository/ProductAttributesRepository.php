<?php

namespace Ecommerce\BiologischekaasBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ProductAttributesRepository extends EntityRepository {

    public function findbyAttributeLike($like) {

        $sql = "SELECT pa FROM BiologischekaasBundle:ProductAttributes pa WHERE pa.attributeValue LIKE '".$like."'";

        return $this->getEntityManager()->createQuery($sql)->getResult();
    }

}