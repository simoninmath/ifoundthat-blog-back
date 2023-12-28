<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Article>
 *
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    // DQL request which return Array before encoding in JSON format
    /**
     * @return array
     */
    public function getAllArticlesWithDql(): array
    {
        // arts = All articles
        $dql = "SELECT
               arts.id, arts.title, arts.chapo, 
               arts.createdAt, arts.updatedAt
               FROM App\Entity\Article as arts
               ";

        $query = $this->getEntityManager()->createQuery($dql);
        $result = $query->getResult();

        return $result;
    }


    public function getOneArticleByIdWithDql($articleId)
    {
        $dql = "SELECT art.id, art.title, 
                art.chapo, art.createdAt, 
                art.updatedAt
                FROM App\Entity\Article as art
                WHERE art.id = :articleId";    // Condition that check if it is the correct Id
    
        $query = $this->getEntityManager()->createQuery($dql);
        $query->setParameter('articleId', $articleId);   // Bond with Id pass on Method Argument
    
        $result = $query->getResult();
    
        return $result;
    }


    public function createOneArticleWithDql()
    {
        $dql = "SELECT art.id, art.title, 
                art.chapo, art.createdAt, 
                art.updatedAt
                FROM App\Entity\Article as art
                WHERE art.id = :articleId";    // Condition that check if it is the correct Id
    
        $query = $this->getEntityManager()->createQuery($dql);
    
        $result = $query->getResult();
    
        return $result;
    }
    
}
