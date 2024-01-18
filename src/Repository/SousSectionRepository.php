<?php

namespace App\Repository;

use App\Entity\SousSection;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SousSection>
 *
 * @method SousSection|null find($id, $lockMode = null, $lockVersion = null)
 * @method SousSection|null findOneBy(array $criteria, array $orderBy = null)
 * @method SousSection[]    findAll()
 * @method SousSection[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SousSectionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SousSection::class);
    }

//    /**
//     * @return SousSection[] Returns an array of SousSection objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?SousSection
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
