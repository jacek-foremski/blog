<?php

namespace AppBundle\Entity;

class PostRepository extends \Doctrine\ORM\EntityRepository
{
    public function findAllActive()
    {
        return $this->createQueryBuilder('p')
            ->where('p.isActive = TRUE')
            ->getQuery();
    }

    public function findAllActiveInMonth(\DateTime $month){
        return $this->createQueryBuilder('p')
            ->where('p.isActive = TRUE')
            ->andWhere('DATE_TRUNC(\'month\', p.createdAt) = :month')
            ->setParameter('month', $month)
            ->getQuery();
    }

    public function findDistinctCreationDateMonths()
    {
        return $this->createQueryBuilder('p')
            ->select('DATE_TRUNC(\'month\', p.createdAt) AS month')
            ->where('p.isActive = TRUE')
            ->distinct()
            ->orderBy('month', 'ASC')
            ->getQuery()
            ->getResult();
    }

}
