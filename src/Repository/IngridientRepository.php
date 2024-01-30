<?php

namespace App\Repository;

use App\Entity\Ingridient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Ingridient>
 *
 * @method Ingridient|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ingridient|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ingridient[]    findAll()
 * @method Ingridient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IngridientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ingridient::class);
    }

    public function getAllIngridients() : array {
        $result = $this->createQueryBuilder('i')->getQuery()->getArrayResult();
        return array_column($result, "name");
    }
//    /**
//     * @return Ingridient[] Returns an array of Ingridient objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Ingridient
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
