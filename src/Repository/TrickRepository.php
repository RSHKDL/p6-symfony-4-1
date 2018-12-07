<?php

namespace App\Repository;

use App\Entity\Trick;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Trick|null find($id, $lockMode = null, $lockVersion = null)
 * @method Trick|null findOneBy(array $criteria, array $orderBy = null)
 * @method Trick[]    findAll()
 * @method Trick[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrickRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Trick::class);
    }

    public function getPaginatedTricks($page, $nbPerPage)
    {
        $query = $this->createQueryBuilder('f')
            ->leftJoin('f.categories', 'c')
            ->addSelect('c')
            ->orderBy('f.createdAt', 'DESC')
            ->getQuery();

        $query->setFirstResult(($page - 1) * $nbPerPage)->setMaxResults($nbPerPage);

        return new Paginator($query, true);
    }

    public function getLastTricks(int $limit)
    {
        $query = $this->findBy(
            [],
            ['createdAt' => 'DESC'],
            $limit);

        return $query;
    }

    /**
     * Save the trick into the database
     *
     * @param Trick $figure
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Trick $figure)
    {
        $this->_em->persist($figure);
        $this->_em->flush();
    }

    /**
     * Update a trick
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function update(Trick $figure): void
    {
        $this->_em->persist($figure);
        $this->_em->flush();
    }

    /**
     * Remove a trick
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function remove(Trick $figure): void
    {
        $this->_em->remove($figure);
        $this->_em->flush();
    }
}
