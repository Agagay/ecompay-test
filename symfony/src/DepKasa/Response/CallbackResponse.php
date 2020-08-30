<?php


namespace App\DepKasa\Response;


class CallbackResponse extends BaseResponse
{
    const STATUS_APPROVED = 'APPROVED';
    const STATUS_DECLINED = 'DECLINED';
    const STATUS_CANCELED = 'CANCELED';
    const STATUS_PENDING = 'PENDING';
    const STATUS_ERROR = 'ERROR';

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