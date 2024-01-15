<?php

namespace App\Repository;

use App\Entity\Form;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Form>
 *
 * @method Form|null find($id, $lockMode = null, $lockVersion = null)
 * @method Form|null findOneBy(array $criteria, array $orderBy = null)
 * @method Form[]    findAll()
 * @method Form[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FormRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Form::class);
    }

    public function createFormWithDql()
    {
        $dql = "SELECT form.id, form.name, 
                form.email, form.message
                FROM App\Entity\Form as form
                WHERE form.id = :formId";    // Condition that check if it is the correct Id
    
        $query = $this->getEntityManager()->createQuery($dql);
    
        $result = $query->getResult();
    
        return $result;
    }

}
