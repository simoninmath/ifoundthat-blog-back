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
    ) {
        parent::__construct($registry, Newsletter::class);
    }

    // public function fetchInfoFromNewsletterWithDql(): array
    // {
    //      // DQL request which return Array
    //     $dql = "SELECT newsletterinfo.id, newsletterinfo.email  
    //            FROM App\Entity\Newsletter AS newsletterinfo";

    //     // Create a query using the EntityManager and execute it
    //     $query = $this->getEntityManager()->createQuery($dql);
    //     $result = $query->getResult();

    //     return $result;
    // }


    // Fetch information from newsletters using DQL (Doctrine Query Language)
    public function fetchInfoFromNewsletterWithDql(): array
    {
        $entityManager = $this->getDoctrine()->getManager();
        $query = $entityManager->createQuery(
            'SELECT newsletter.id, newsletter.email
             FROM App\Entity\Newsletter AS newseletter'
        );

        $result = $query->getResult();

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


    // public function insertEmailFromNewsletter(int $id, string $email): void
    // {
    //     // Use EntityManager to execute query with parameters
    //     $conn = $this->getEntityManager()->getConnection();

    //     $sql = "INSERT INTO ma_table (id, email, createdAt) 
    //             VALUES (?, ?, NOW())";
    //     $conn->executeUpdate($sql, [$id, $email]);
    // }

}
