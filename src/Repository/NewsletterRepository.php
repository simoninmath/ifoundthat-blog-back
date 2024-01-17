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
    // Constructor for the NewsletterRepository.    
    public function __construct(
        ManagerRegistry $registry
        )
    {
        parent::__construct($registry, Newsletter::class);
    }
   
    // Fetch information from newsletters using DQL (Doctrine Query Language)
    public function fetchInfoFromNewsletterWithDql(): array
    {
         // DQL request which return Array
        $dql = "SELECT newsletterinfo.id, newsletterinfo.email  
               FROM App\Entity\Newsletter AS newsletterinfo";

        // Create a query using the EntityManager and execute it
        $query = $this->getEntityManager()->createQuery($dql);
        $result = $query->getResult();

        return $result;
    }
}