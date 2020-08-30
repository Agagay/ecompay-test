<?php

namespace App\Message\DepKasa;


use App\DepKasa\Response\CallbackResponse;

class StatusMessage
{
    private $paymentId;

    public function __construct(int $paymentId)
    {
        $this->paymentId = $paymentId;
    }

    public function getPaymentId(): int
    {
        return $this->paymentId;
    }
}