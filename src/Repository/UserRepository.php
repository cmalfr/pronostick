<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function userGames($id_user)
    {
      return $this->createQueryBuilder('u')
          ->andWhere('u.id = :id_user')
          ->setParameter('id_user', $id_user)
          ->leftJoin('u.pronostic', 'p')
          ->andWhere('u.id = p.iduser')
          ->leftJoin('p.idgame', 'g')
          ->andWhere('g.date >= :datecourant')
          ->setParameter('datecourant', new \Datetime(date('Y-m-d H:i:s')))
          ->select('g.id', 'g.date', 'g.team1', 'g.score1', 'g.score2', 'p.pscore1', 'g.team2', 'p.pscore2', 'p.result')
          ->getQuery()
          ->getResult()
      ;
    }

    public function pastUserGames($id_user)
    {
      return $this->createQueryBuilder('u')
          ->andWhere('u.id = :id_user')
          ->setParameter('id_user', $id_user)
          ->leftJoin('u.pronostic', 'p')
          ->andWhere('u.id = p.iduser')
          ->leftJoin('p.idgame', 'g')
          ->andWhere('g.date <= :datecourant')
          ->setParameter('datecourant', new \Datetime(date('Y-m-d H:i:s')))
          ->select('g.id', 'g.date', 'g.team1', 'g.score1', 'g.score2', 'p.pscore1', 'g.team2', 'p.pscore2', 'p.result')
          ->getQuery()
          ->getResult()
      ;
    }

    public function getusernbpronos($id_user)
    {
      if($id_user != NULL){
        return $this->createQueryBuilder('u')
            ->select('COUNT(p)')
            ->andWhere('u.id = :id_user')
            ->setParameter('id_user', $id_user)
            ->leftJoin('u.pronostic', 'p')
            ->getQuery()
            ->getResult()
        ;
      } else {
        return $this->createQueryBuilder('u')
            ->select('COUNT(p)')
            ->leftJoin('u.pronostic', 'p')
            ->getQuery()
            ->getResult()
        ;
        }
    }

    public function getnbuser()
    {
        return $this->createQueryBuilder('u')
            ->select('COUNT(u)')
            ->getQuery()
            ->getResult()
        ;
      }

    public function getuserbonpronos($id_user)
    {
      if($id_user != NULL){
        return $this->createQueryBuilder('u')
            ->select('COUNT(p)')
            ->andWhere('u.id = :id_user')
            ->andWhere('p.result = 100')
            ->setParameter('id_user', $id_user)
            ->leftJoin('u.pronostic', 'p')
            ->getQuery()
            ->getResult()
        ;
      }else{
        return $this->createQueryBuilder('u')
            ->select('COUNT(p)')
            ->andWhere('p.result = 100')
            ->leftJoin('u.pronostic', 'p')
            ->getQuery()
            ->getResult()
        ;
      }
    }

    public function getClassement()
    {
      return $this->createQueryBuilder('u')
          ->select('u.id', 'u.username', 'SUM(p.result) AS total')
          ->leftJoin('u.pronostic', 'p')
          ->andWhere('p.iduser = u.id')
          ->groupBy('u.id')
          ->orderBy('total', 'DESC')
          ->getQuery()
          ->getResult()
      ;
    }

//    /**
//     * @return User[] Returns an array of User objects
//     */
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
    public function findOneBySomeField($value): ?User
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
