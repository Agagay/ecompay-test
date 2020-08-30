<?php

namespace App\Controller\Message\DepKasa;


class StatusMessage
{
    private $paymentId;

    public function __construct(int $id)
    {
        $this->paymentId = $id;
    }

    public function getPaymentId(): int
    {
        return $this->paymentId;
    }
}