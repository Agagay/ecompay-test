<?php


namespace App\DepKasa\Request;


class DetailRequest extends BaseRequest
{
    public function getMethod()
    {
        return 'payment/detail';
    }
}