<?php

namespace App\Repository;

use App\Entity\PaymentStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PaymentStatus|null find($id, $lockMode = null, $lockVersion = null)
 * @method PaymentStatus|null findOneBy(array $criteria, array $orderBy = null)
 * @method PaymentStatus[]    findAll()
 * @method PaymentStatus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PaymentStatusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PaymentStatus::class);
    }

    public function findStatusByCode($code): ?PaymentStatus
    {
        return $this->findOneBy(['code' => $code]);
    }
}
