<?php

namespace App\MessageHandler\DepKasa;


use App\Controller\Message\DepKasa\StatusMessage;
use App\Entity\Payment;
use App\Entity\PaymentStatus;
use App\Entity\PaymentStatusLog;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class StatusMessageHandler implements MessageHandlerInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $em)
    {
        $this->entityManager = $em;
    }

    public function __invoke(StatusMessage $statusMessage)
    {
        $payment = $this->entityManager->getRepository(Payment::class)->find($statusMessage->getPaymentId());

        $status = $this
            ->getEm()
            ->getRepository(PaymentStatus::class)
            ->findStatusByCode(PaymentStatus::STATUS_SUCCESS);

        $paymentLog = new PaymentStatusLog();
        $paymentLog->setIdStatus($status);
        $payment->addPaymentStatusLog($paymentLog);
        $this->entityManager->flush();
    }
}