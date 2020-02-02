<?php

namespace App\Repository;

use App\Entity\Distances;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Distances|null find($id, $lockMode = null, $lockVersion = null)
 * @method Distances|null findOneBy(array $criteria, array $orderBy = null)
 * @method Distances[]    findAll()
 * @method Distances[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DistancesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Distances::class);
    }

    // /**
    //  * @return Distances[] Returns an array of Distances objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Distances
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
