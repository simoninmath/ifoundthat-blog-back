<?php

namespace App\Repository;

use App\Entity\UserConnexion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserConnexion>
 *
 * @method UserConnexion|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserConnexion|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserConnexion[]    findAll()
 * @method UserConnexion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserConnexionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserConnexion::class);
    }

//    /**
//     * @return UserConnexion[] Returns an array of UserConnexion objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?UserConnexion
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
