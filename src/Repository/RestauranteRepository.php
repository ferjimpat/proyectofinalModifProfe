<?php

namespace App\Repository;

use App\Entity\Restaurante;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Parameter;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Restaurante|null find($id, $lockMode = null, $lockVersion = null)
 * @method Restaurante|null findOneBy(array $criteria, array $orderBy = null)
 * @method Restaurante[]    findAll()
 * @method Restaurante[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RestauranteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Restaurante::class);
    }

    public function finbByDayAndTime($dia, $hora, $idMunicipio){

        return $this->createQueryBuilder('r')
            ->join('r.horarios', 'h')
            ->join('r.municipiosReparto', 'm')
            ->where('m.id = :idMunicipio')
            ->andWhere('h.dia = :dia')
            ->andWhere('h.apertura <= :hora')
            ->andWhere('h.cierre >= :hora')
            ->setParameters( new ArrayCollection(
                array (
                    new Parameter('idMunicipio', $idMunicipio),
                    new Parameter('dia', $dia),
                    new Parameter('hora', $hora)
                )
            ))
            ->orderBy('r.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

}
