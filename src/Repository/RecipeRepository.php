<?php

namespace App\Repository;

use App\Entity\Recipe;
use App\Model\SearchData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @extends ServiceEntityRepository<Recipe>
 */
class RecipeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Recipe::class);
    }

       /**
        * @return Recipe[] Returns an array of Recipe objects
        * Cette methode permet de recuperer les recettes qui ont moins d'une durée donnée en paramètre
        */
       public function findRecipeDurationLowerThan(int $duration): array
       {
           return $this->createQueryBuilder('r')
               ->where('r.duration <= :duration')
               ->setParameter('duration', $duration)
               ->orderBy('r.duration', 'ASC')
               ->getQuery()
               ->getResult()
           ;
       }

       public function findBySearch(SearchData $searchData): Query
       {
            $data = $this->createQueryBuilder('r')
            ->addOrderBy('r.createdAt', 'DESC');
        if (!empty($searchData->q)) {
            $data = $data
                //recherche que sur le titre
                ->andWhere('r.title LIKE :q')
                //Si on veut rajouter aussi la recherche dans le contenu
                // ->orWhere('r.content LIKE :query')
                ->setParameter('q', "%{$searchData->q}%");
        }
        
        return $data
            ->getQuery();
        }
}
