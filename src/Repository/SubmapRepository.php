<?php

namespace App\Repository;

use App\Entity\Submap;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Submap|null find($id, $lockMode = null, $lockVersion = null)
 * @method Submap|null findOneBy(array $criteria, array $orderBy = null)
 * @method Submap[]    findAll()
 * @method Submap[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubmapRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Submap::class);
    }

    // /**
    //  * @return Submap[] Returns an array of Submap objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Submap
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
