<?php

namespace App\Repository;

use App\Entity\Alergeno;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Alergeno|null find($id, $lockMode = null, $lockVersion = null)
 * @method Alergeno|null findOneBy(array $criteria, array $orderBy = null)
 * @method Alergeno[]    findAll()
 * @method Alergeno[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AlergenoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Alergeno::class);
    }

    // /**
    //  * @return Alergeno[] Returns an array of Alergeno objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Alergeno
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
