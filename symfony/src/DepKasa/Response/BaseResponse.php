<?php


namespace App\DepKasa\Response;


class BaseResponse
{
    public function parseResponse($fields)
    {
        foreach ($fields as $field => $value) {
            $this->{$field} = $value;
        }

        return $this;
    }
}