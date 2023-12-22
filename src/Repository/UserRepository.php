<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @implements PasswordUpgraderInterface<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    /**
     * @return array
     */
    public function getUsersInfo(): array
    {
        $dql = "SELECT
               u.email, u.role, u.createdAt
               FROM App\Entity\User as u
               JOIN u.userconnexion as uc
               WHERE uc.createdAt LIKE :createdAt";

        return $this->createQueryBuilder('u')
            ->select('u.email', 'u.role', 'u.createdAt')
            ->getQuery()
            ->getResult();
    }

    // DQL request
    /**
     * @return array
     */
    public function getUsersInfoWithDql(): array
    {
        $dql = "SELECT
               u.id, u.email
               FROM App\Entity\User as u
               ";

        $query = $this->getEntityManager()->createQuery($dql);
        $result = $query->getResult();

        return $result;
    }

    // QueryBuilder -> Design Pattern Builder
    /**
     * @return array
     */
    public function getUserInfoWithQueryBuilder(): array
    {
       return $this->createQueryBuilder('u')
            ->select(
                'u.id, 
                u.email'
            )
            ->getQuery()
            ->getResult()
       ;
    }
}
