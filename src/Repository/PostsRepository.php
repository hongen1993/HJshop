<?php

namespace App\Repository;

use App\Entity\Posts;
use App\Entity\PropertySearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\Query\QueryBuilder;
use Doctrine\ORM\QueryBuilder as ORMQueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Posts|null find($id, $lockMode = null, $lockVersion = null)
 * @method Posts|null findOneBy(array $criteria, array $orderBy = null)
 * @method Posts[]    findAll()
 * @method Posts[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Posts::class);
    }
    public function BuscarTodosLosPosts(){
        return $this->getEntityManager()
            ->createQuery('
            SELECT  post.id, post.name, post.foto, post.precioAntes, post.precio, post.fechaPublicacion, post.stock
            From App:Posts post
            ');
    }
    public function PostsRecientes(){
        $qb = $this->createQueryBuilder('p')
        ->orderBy('p.id', 'DESC')
        ->setFirstResult(0)
        ->setMaxResults(8);
        return $qb->getQuery()
        ->getResult();
    }
    /**
     * @param string $query
     * $return mixed
     */
public function findPostsByName(string $query){
    $qb = $this->createQueryBuilder('p');
    $qb
        ->where(
            $qb->expr()->andX(
                $qb->expr()->orX(
                    $qb->expr()->like('p.name', ':query'),
                    $qb->expr()->like('p.foto', ':query')

                ),
                $qb->expr()->isNotNull('p.fechaPublicacion')
            )
        )
        ->setParameter('query','%' .$query . '%');
        return $qb
                ->getQuery()
                ->getResult();
}

    /**
     * @return @Query
     */
    public function findAllVisibleQuery(PropertySearch $search): Query
    {
        $query = $this->findVisibleQuery();
         
        if ($search->getMinPrice()){
            $query = $query
            ->andWhere('p.precio >= :minprice')
            ->setParameter('minprice', $search->getMinPrice());
        }
        if ($search->getMaxPrice()){
            $query = $query
            ->andWhere('p.precio <= :maxprice')
            ->setParameter('maxprice', $search->getMaxPrice());
        }
         return $query->getQuery();
    }

    private function findVisibleQuery(): ORMQueryBuilder{
        return $this->createQueryBuilder('p')
        ->where('p.stock >= 0');
    }
    // /**
    //  * @return Posts[] Returns an array of Posts objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Posts
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
