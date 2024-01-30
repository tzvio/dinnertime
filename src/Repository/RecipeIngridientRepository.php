<?php

namespace App\Repository;

use App\Entity\RecipeIngridient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RecipeIngridient>
 *
 * @method RecipeIngridient|null find($id, $lockMode = null, $lockVersion = null)
 * @method RecipeIngridient|null findOneBy(array $criteria, array $orderBy = null)
 * @method RecipeIngridient[]    findAll()
 * @method RecipeIngridient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecipeIngridientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RecipeIngridient::class);
    }

    public function findRecipesByIngridients($ingridients) {
        if (empty($ingridients)) {
            return [];
        }
        $query = $this->createQueryBuilder('i')->select('i');
        $query->join('i.recipe', 'r')->addSelect('r');
        foreach ($ingridients as $index => $ingridient) {
                $query->orWhere('i.ingridient LIKE ?' . $index);
                $query->setParameter($index , '%'.$ingridient.'%');
        }
        $results = $query->getQuery()->getArrayResult();
        $recipes = [];
        foreach ($results as $recipe) {
            $recipes[] = $recipe['recipe']['id'];
        }
        return $recipes;
    }
//    /**
//     * @return RecipeIngridient[] Returns an array of RecipeIngridient objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?RecipeIngridient
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
