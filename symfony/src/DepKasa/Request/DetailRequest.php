<?php


namespace App\DepKasa\Request;


class DetailRequest extends BaseRequest
{
    public $referenceNo;

    public function getMethod()
    {
        return 'payment/detail';
    }
}