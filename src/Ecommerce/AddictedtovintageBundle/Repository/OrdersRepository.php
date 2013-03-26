<?php

namespace Ecommerce\AddictedtovintageBundle\Repository;

use Doctrine\ORM\EntityRepository;

class OrdersRepository extends EntityRepository {

    public function getNewOrderNr() {

        $new_order_nr = 0;

        $today = new \DateTime();
        $today->setTime('01', '00', '00');

        $orders = $this->createQueryBuilder('o')
                        ->where('o.createdAt > :dateTime')
                        ->setParameter('dateTime', $today)
                        ->getQuery()->getResult();

        if ($orders == null) {

            $new_order_nr = $today->format('Ymd') . '001';
        } else {

            if (count($orders) < 100) {
                if (count($orders) < 10) {
                    $new_order_nr = $today->format('Ymd') . '00' . count($orders) + 1;
                } else {
                    $new_order_nr = $today->format('Ymd') . '0' . count($orders) + 1;
                }
            } else {
                $new_order_nr = $today->format('Ymd') . count($orders) + 1;
            }
        }

        return $new_order_nr;
    }

    public function getTotalOrdersPrice(\Ecommerce\AddictedtovintageBundle\Entity\Client $client) {

        $orders = $this->createQueryBuilder('o')
                        ->where('o.client = :client')
                        ->setParameter('client', $client)
                        ->getQuery()->getResult();

        $totalPrice = 0;

        foreach ($orders as $order) {
            $totalPrice = ($totalPrice + $order->getTotal());
        }

        return number_format($totalPrice, 2, ',', '.');
    }

    public function findOrdersByAdminFilter($status, $paymethod, $shipping) {

        $qb = $this->createQueryBuilder('o');

        switch ($status) {

            case "1" :
                $qb->andWhere('o.payed = 0');
                break;

            case "2" :
                $qb->andWhere('o.payed = 1');
                break;
        }

        if ($paymethod != null) {
            $qb->andWhere('o.paymethod = :paymethod');
            $qb->setParameter('paymethod', $paymethod);
        }

        if ($shipping != null) {
            $qb->andWhere('o.shipping = :shipping');
            $qb->setParameter('shipping', $shipping);
        }

        return $qb->getQuery()->getResult();
    }

    public function getOrdersCountByWeeks($nrOfWeeks) {

        $qb = $this->createQueryBuilder('o');

        $days = $nrOfWeeks * 7;
        $now = new \DateTime();
        
        $start = $now->sub(new \DateInterval('P'.$days.'D'));
        
        $qb->where('o.createdAt < :start');
        $qb->setParameter('start', $start->format('Y-m-d'));
        
        $end = $now->sub(new \DateInterval('P7D'));

        $qb->andWhere('o.createdAt > :end');
        $qb->setParameter('end', $end->format('Y-m-d'));
        
        $qb->select('COUNT(o.id)');

        return $qb->getQuery()->getSingleScalarResult();
    }
    
    public function getOrdersWaitingForShpping($maxResults) {

        $qb = $this->createQueryBuilder('o');

        $now = new \DateTime();

        $qb->where('o.shippingDate > :now');
        $qb->setParameter('now', $now->format('Y-m-d'));
        
        $qb->setMaxResults($maxResults);
        
        return $qb->getQuery()->getResult();
    }

    public function getProfitByMonth($month) {

        $qb = $this->createQueryBuilder('o');

        $now = new \DateTime('midnight first day of '.$month.' month');
                
        $qb->andWhere('o.createdAt > :end');
        $qb->setParameter('end', $now->format('Y-m-d'));
        
        $qb->select('SUM(o.total)');

        return $qb->getQuery()->getSingleScalarResult();
    }

    public function findOrdersByMaxResults($maxResults) {

        $qb = $this->createQueryBuilder('o');
        $qb->setMaxResults($maxResults);
        
        $qb->orderBy('o.id', 'DESC');
        
        return $qb->getQuery()->getResult();
    }

}

?>