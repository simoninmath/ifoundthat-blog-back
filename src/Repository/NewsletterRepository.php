<?php

namespace App\Repository;

use App\Entity\Newsletter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Newsletter>
 *
 * @method Newsletter|null find($id, $lockMode = null, $lockVersion = null)
 * @method Newsletter|null findOneBy(array $criteria, array $orderBy = null)
 * @method Newsletter[]    findAll()
 * @method Newsletter[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */

class NewsletterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Newsletter::class);
    }

    // DQL request which return Array before encoding in JSON format
    //TODO changer annotation en PHP8
    /**
     * @return array
     */
    public function getUsersFromNewsletterWithDql(): array
    {
        // nlu = NewsLetter User
        $dql = "SELECT
               nlu.id, nlu.email
               FROM App\Entity\Newsletter as nlu
               ";

        $query = $this->getEntityManager()->createQuery($dql);
        $result = $query->getResult();

        return $result;
    }
    //TODO créer requêtes pour suite CRUD
}