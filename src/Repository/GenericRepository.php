<?php

namespace App\Repository;

use App\Entity\Generic;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Generic|null find($id, $lockMode = null, $lockVersion = null)
 * @method Generic|null findOneBy(array $criteria, array $orderBy = null)
 * @method Generic[]    findAll()
 * @method Generic[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GenericRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Generic::class);
    }

    // /**
    //  * @return Generic[] Returns an array of Generic objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Generic
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
