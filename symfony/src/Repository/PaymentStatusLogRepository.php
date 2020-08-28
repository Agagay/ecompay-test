<?php

namespace App\Repository;

use App\Entity\PaymentStatusLog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PaymentStatusLog|null find($id, $lockMode = null, $lockVersion = null)
 * @method PaymentStatusLog|null findOneBy(array $criteria, array $orderBy = null)
 * @method PaymentStatusLog[]    findAll()
 * @method PaymentStatusLog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PaymentStatusLogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PaymentStatusLog::class);
    }

    // /**
    //  * @return PaymentStatusLog[] Returns an array of PaymentStatusLog objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PaymentStatusLog
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
