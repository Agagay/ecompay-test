<?php

namespace App\Controller;

use App\Controller\Message\DepKasa\StatusMessage;
use App\DepKasa\DepKasa;
use App\DepKasa\Request\WelcomeRequest;
use App\DepKasa\Response\CallbackResponse;
use App\DepKasa\Response\WelcomeResponse;
use App\Entity\Payment;
use App\Entity\PaymentStatus;
use App\Entity\PaymentStatusLog;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/depkasa", name="dep_kasa")
 */
class DepKasaController extends BaseController
{
    /**
     * @Route("/welcome", methods={"POST"})
     */
    public function welcome(Request $request, DepKasa $depKasa)
    {
        $fields = json_decode($request->getContent(), true);

        /** 1 */
        $paymentLog = $this->createPaymentStatusLog(PaymentStatus::STATUS_INIT);
        $payment = new Payment();
        $payment
            ->setAmount($fields['amount'])
            ->setCurrency($fields['currency'])
            ->addPaymentStatusLog($paymentLog);

        $this->getEm()->persist($payment);

        try {
            // Добавить валидацию перед сохранением
            $this->getEm()->flush();
        } catch (\Exception $exception) {
            return $this->json(['error' => $exception->getMessage()]);
        }

        /** 2 */
        // код ниже унести в messenger для асинхронной обработки
        $paymentLog = $this->createPaymentStatusLog(PaymentStatus::STATUS_EXTERNAL);
        $payment->addPaymentStatusLog($paymentLog);
        $this->getEm()->persist($payment);
        $this->getEm()->flush();

        $apiRequest = new WelcomeRequest(array_merge($fields, ['referenceNo' => $payment->getId()]));
        $apiResponse = new WelcomeResponse();
        $response = $depKasa->welcome($apiRequest, $apiResponse);

        /** 3 */
        $paymentLog = $this->createPaymentStatusLog(PaymentStatus::STATUS_DELIVERED);
        $payment
            ->setIdExternalTransaction($response->transactionId)
            ->addPaymentStatusLog($paymentLog);
        $this->getEm()->persist($payment);
        $this->getEm()->flush();

        /** 4 */
        $paymentLog = $this->createPaymentStatusLog(PaymentStatus::STATUS_CALLBACK);
        $payment->addPaymentStatusLog($paymentLog);
        $this->getEm()->persist($payment);
        $this->getEm()->flush();

        return $this->json([
            'message' => 'transaction created',
            'timestamp' => $apiRequest->timestamp,
            'transactionInner' => $payment->getId(),
            'transactionOuter' => $payment->getIdExternalTransaction(),
        ]);
    }
    /**
     * @Route("/callback", methods={"POST"})
     */
    public function callback(Request $request, DepKasa $depKasa, MessageBusInterface $bus)
    {
        $fields = json_decode($request->getContent(), true);

        $apiResponse = new CallbackResponse();
        $apiResponse->parseResponse($fields);
        $token = DepKasa::generateCallbackToken(
            $apiResponse->code,
            $apiResponse->status,
            $apiResponse->amount,
            $apiResponse->currency,
            $apiResponse->referenceNo,
            $apiResponse->timestamp
        );

        if ($token !== $apiResponse->token) {
            $this->json(['error' => 'Invalid token']);
        }

        $paymentRepository = $this->getEm()->getRepository(Payment::class);
        $payment = $paymentRepository->find($apiResponse->referenceNo);

//        $paymentLog = $this->createPaymentStatusLog(PaymentStatus::STATUS_RECEIVED);
//        $payment
//            ->setIdExternalTransaction($apiResponse->transactionId)
//            ->addPaymentStatusLog($paymentLog);
//        $this->getEm()->flush();

        try {

            $bus->dispatch(new StatusMessage($payment->getId()));
        } catch (\Exception $e) {
            dd($e);
        }

        dd($apiResponse);

        // parse $apiResponse

    }

    private function createPaymentStatusLog(string $code)
    {
        $status = $this
            ->getEm()
            ->getRepository(PaymentStatus::class)
            ->findStatusByCode($code);
        $paymentLog = new PaymentStatusLog();
        $paymentLog->setIdStatus($status);
        return $paymentLog;
    }
}
