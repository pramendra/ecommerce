<?php

namespace AddictedToVintage\EcommerceBundle\Repository;

use Doctrine\ORM\EntityRepository;

class PostcodeRepository extends EntityRepository {

    public function getAdrressByPostcode($zipcode) {
        $zipcode_numbers = \substr($zipcode, 0, 4);
        $zipcode_letters = \substr($zipcode, 4, 2);

        $sql = "SELECT s.street AS street, s.lat AS lat, s.lng AS lng, p.fourpp AS postcode, s.chars AS chars, cn.name AS city, pr.name AS province, co.name AS country
						FROM `postcode` p
						INNER JOIN `city` c
						ON c.id = p.city_id
						INNER JOIN `cityname` cn
						ON c.id = cn.city_id
						INNER JOIN `province` pr
						ON pr.id = c.province_id
						INNER JOIN `country` co
						ON co.id = pr.country_id
						INNER JOIN `street` s
						ON p.id = s.postcode_id
						WHERE p.fourpp = ? AND cn.official = '1' AND s.chars = ? LIMIT 1";

        $conn = $this->getEntityManager()->getConnection();
        $result = $conn->fetchAll($sql, array($zipcode_numbers, $zipcode_letters));

        return $result;
    }

}