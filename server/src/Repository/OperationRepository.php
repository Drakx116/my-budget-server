<?php

namespace App\Repository;

use App\Entity\Operation;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Operation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Operation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Operation[]    findAll()
 * @method Operation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OperationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Operation::class);
    }

    public function add(Operation $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function remove(Operation $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function findUserLastOperations(User $user, int $limit)
    {
        $qb = $this->createQueryBuilder('operation')
            ->select('LOWER(operation.type) as type, operation.label, operation.amount, LOWER(operation.method) as method, operation.date')
            ->andWhere('operation.author = :user')
            ->setParameter('user', $user)
            ->orderBy('operation.date', 'DESC');

        if ($limit) {
            $qb->setMaxResults($limit);
        }

        return $qb->getQuery()->getResult();
    }


    public function findUserSummary(User $user): array
    {
        return $this->createQueryBuilder('operation')
            ->select('LOWER(operation.type) as type, SUM(operation.amount) as total')
            ->andWhere('operation.author = :user')
            ->setParameter('user', $user)
            ->groupBy('operation.type')
            ->getQuery()
            ->getArrayResult();
    }
}
