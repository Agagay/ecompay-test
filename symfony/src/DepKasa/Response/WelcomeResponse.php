<?php


namespace App\DepKasa\Response;


class WelcomeResponse extends BaseResponse
{
    public $amount;
    public $currency;
    public $message;
    public $paymentMethod;
    public $referenceNo;
    public $returnForm;
    public $returnUrl;
    public $status;
    public $token;
    public $transactionId;
}