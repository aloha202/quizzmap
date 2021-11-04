<?php

namespace App\Repository;

use App\Entity\UserQuizzTake;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserQuizzTake|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserQuizzTake|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserQuizzTake[]    findAll()
 * @method UserQuizzTake[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserQuizzTakeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserQuizzTake::class);
    }

    // /**
    //  * @return UserQuizzTake[] Returns an array of UserQuizzTake objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserQuizzTake
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
