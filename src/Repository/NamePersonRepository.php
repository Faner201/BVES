<?php

namespace App\Repository;

use App\Entity\NamePerson;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NamePerson|null find($id, $lockMode = null, $lockVersion = null)
 * @method NamePerson|null findOneBy(array $criteria, array $orderBy = null)
 * @method NamePerson[] findAll()
 * @method NamePerson[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NamePersonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NamePerson::class);
    }
}
