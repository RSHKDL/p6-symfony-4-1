<?php

namespace App\Repository;

use App\Entity\Figure;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Figure|null find($id, $lockMode = null, $lockVersion = null)
 * @method Figure|null findOneBy(array $criteria, array $orderBy = null)
 * @method Figure[]    findAll()
 * @method Figure[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FigureRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Figure::class);
    }

    public function getFigures($page, $nbPerPage)
    {
        $query = $this->createQueryBuilder('f')->getQuery();

        $query->setFirstResult(($page - 1) * $nbPerPage)->setMaxResults($nbPerPage);

        return new Paginator($query, true);
    }
}
