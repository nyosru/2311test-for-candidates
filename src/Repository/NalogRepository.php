<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Nalog;

/**
 * @extends ServiceEntityRepository<\Nalog>
 *
 * @method Nalog|null find($id, $lockMode = null, $lockVersion = null)
 * @method Nalog|null findOneBy(array $criteria, array $orderBy = null)
 * @method Nalog[]    findAll()
 * @method Nalog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NalogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Nalog::class);
    }

//    /**
//     * @return Nalog[] Returns an array of Nalog objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('n.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Nalog
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
