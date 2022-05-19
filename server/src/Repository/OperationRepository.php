<?php

namespace App\Repository;

use App\Entity\Operation;
use App\Entity\User;
use App\Enum\OperationType;
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

    public function findUserLastOperations(User $user, int $limit, ?OperationType $type)
    {
        $qb = $this->createQueryBuilder('operation')
            ->andWhere('operation.author = :user')
            ->setParameter('user', $user)
            ->orderBy('operation.date', 'DESC');

        if ($limit) {
            $qb->setMaxResults($limit);
        }

        if ($type) {
            $qb ->andWhere('operation.type = :type')
                ->setParameter('type', $type->name);
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
