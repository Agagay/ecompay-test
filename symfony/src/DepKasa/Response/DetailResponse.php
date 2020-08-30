<?php


namespace App\DepKasa\Response;


class DetailResponse extends BaseResponse
{
    public $code;
    public $status;
    public $message;
    public $referenceNo;
    public $transactionId;
    public $amount;
    public $currency;
}