<?php

namespace App\Repository;

use App\Entity\Game;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Game|null find($id, $lockMode = null, $lockVersion = null)
 * @method Game|null findOneBy(array $criteria, array $orderBy = null)
 * @method Game[]    findAll()
 * @method Game[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Game::class);
    }



    public function upcomingGames($usergames)
    {
      if($usergames != NULL){
        return $this->createQueryBuilder('g')
            ->andWhere('g.date >= :datecourant')
            ->setParameter('datecourant', new \Datetime(date('Y-m-d H:i:s')))
            ->andWhere('g.id NOT IN (:usergames)')
            ->setParameter('usergames', $usergames)
            ->orderBy('g.date', 'ASC')
            ->getQuery()
            ->getResult();
        ;
      } else {
        return $this->createQueryBuilder('g')
            ->andWhere('g.date >= :datecourant')
            ->setParameter('datecourant', new \Datetime(date('Y-m-d H:i:s')))
            ->orderBy('g.date', 'ASC')
            ->getQuery()
            ->getResult();
        ;
      }
    }

    public function pastgGames()
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.date <= :datecourant')
            ->setParameter('datecourant', new \Datetime(date('Y-m-d H:i:s')))
            ->orderBy('g.date', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    // public function findBonPronostic($id_game)
    // {
    //     return $this->createQueryBuilder('g')
    //         ->andWhere('g.id = :id_game')
    //         ->leftJoin('g.pronostics', 'p')
    //         ->andWhere('g.score1 = p.score1')
    //         ->andWhere('g.score2 = p.score2')
    //         ->setParameter('id_game', $id_game)
    //         ->getQuery()
    //         ->getResult()
    //     ;
    // }


//    /**
//     * @return Game[] Returns an array of Game objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Game
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
