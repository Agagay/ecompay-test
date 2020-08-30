<?php

namespace App\MessageHandler\DepKasa;


use App\DepKasa\DepKasa;
use App\DepKasa\Request\DetailRequest;
use App\DepKasa\Response\DetailResponse;
use App\Message\DepKasa\StatusMessage;
use App\DepKasa\Response\CallbackResponse;
use App\Entity\Payment;
use App\Entity\PaymentStatus;
use App\Entity\PaymentStatusLog;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class StatusMessageHandler implements MessageHandlerInterface
{
    private $entityManager;
    private  $depkasa;

    public function __construct(EntityManagerInterface $em, DepKasa $depKasa)
    {
        $this->entityManager = $em;
        $this->depkasa = $depKasa;
    }

    public function __invoke(StatusMessage $statusMessage)
    {
        $payment = $this
            ->entityManager
            ->getRepository(Payment::class)
            ->find($statusMessage->getPaymentId());

        $apiRequest = new DetailRequest(['referenceNo' => $statusMessage->getPaymentId()]);
        $apiResponse = new DetailResponse();

        $result = $this->depkasa->detail($apiRequest, $apiResponse);

        switch ($result->status) {
            case CallbackResponse::STATUS_APPROVED:
                $paymentLog = $this->createPaymentStatusLog(PaymentStatus::STATUS_SUCCESS);
                $payment->addPaymentStatusLog($paymentLog);
                break;
            case CallbackResponse::STATUS_DECLINED:
                $paymentLog = $this->createPaymentStatusLog(PaymentStatus::STATUS_DECLINE);
                $payment->addPaymentStatusLog($paymentLog);
                break;
            default:
                throw new \Exception('Unknown status');
        }

        $this->entityManager->flush();
    }

    private function createPaymentStatusLog(string $code)
    {
        $status = $this
            ->entityManager
            ->getRepository(PaymentStatus::class)
            ->findStatusByCode($code);
        $paymentLog = new PaymentStatusLog();
        $paymentLog->setIdStatus($status);
        return $paymentLog;
    }
}