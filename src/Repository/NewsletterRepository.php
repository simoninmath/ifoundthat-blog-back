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

class NewsletterRepository extends ServiceEntityRepository {

    // Constructor for the NewsletterRepository.    
    public function __construct(
        ManagerRegistry $registry
    ) {
        parent::__construct($registry, Newsletter::class);
    }


    // Fetch information from newsletters using DQL (Doctrine Query Language)
    public function fetchInfoFromNewsletterWithDql(): array
    { 
        $entityManager = $this->getDoctrine()->getManager();  // Create a query using the EntityManager and execute it
        $dql = $entityManager->createQuery(   // DQL request which return Array
            'SELECT newsletter.id, newsletter.email
             FROM App\Entity\Newsletter AS newsletter'
        );

        $result = $dql->getResult();

        return $result;
    }


    // Insert information in newsletters DB using DQL
    public function insertEmailFromNewsletter(int $id, string $email): void
    {
        // Use EntityManager to execute query with parameters
        $entityManager = $this->getDoctrine()->getManager();
        $connection = $entityManager->getConnection();

        $dql = "INSERT INTO newsletter (id, email, createdAt) 
                VALUES (:id, :email, NOW())";

        $preparedQuery = $connection->prepare($dql);
        $preparedQuery->bindParam(':id', $id);
        $preparedQuery->bindParam(':email', $email);
        $preparedQuery->execute();
    }

}
