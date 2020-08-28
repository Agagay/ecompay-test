<?php


namespace App\DepKasa\Response;


class CallbackResponse extends BaseResponse
{
    public $amount;
    public $cardNumber;
    public $code;
    public $currency;
    public $message;
    public $operation;
    public $paymentMethod;
    public $referenceNo;
    public $requestedAmount;
    public $requestedCurrency;
    public $status;
    public $storedCardId;
    public $timestamp;
    public $token;
    public $transactionId;
    public $type;
    public $voucherCode;
}