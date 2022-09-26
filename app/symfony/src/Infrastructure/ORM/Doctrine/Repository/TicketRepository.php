<?php

namespace App\Infrastructure\ORM\Doctrine\Repository;

use App\Domain\Entity\User;
use App\Domain\Entity\Ticket;
use App\Domain\Repository\TicketRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Ticket>
 *
 * @method Ticket|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ticket|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ticket[]    findAll()
 * @method Ticket[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TicketRepository extends ServiceEntityRepository implements TicketRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ticket::class);
    }

    public function add(Ticket $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Ticket $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findOpenTicketsByUser(User $user): array
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.technician_user_id = :user')
            ->andWhere('t.status_id = 1')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult()
            ;
    }

    public function findCompletedTicketsByUser(User $user): array
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.technician_user_id = :user')
            ->andWhere('t.status_id = 2 OR t.status_id = 3')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult()
            ;
    }
}
