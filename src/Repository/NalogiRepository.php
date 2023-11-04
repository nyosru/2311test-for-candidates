<?php

namespace App\Repository;

use App\Entity\Nalogi;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Nalogi>
 *
 * @method Nalogi|null find($id, $lockMode = null, $lockVersion = null)
 * @method Nalogi|null findOneBy(array $criteria, array $orderBy = null)
 * @method Nalogi[]    findAll()
 * @method Nalogi[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NalogiRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Nalogi::class);
    }

//    /**
//     * @return Nalogi[] Returns an array of Nalogi objects
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

//    public function findOneBySomeField($value): ?Nalogi
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
