<?php


namespace App\DepKasa\Request;


abstract class BaseRequest
{
    public function __construct(array $fields)
    {
        $this->load($fields);
    }

    abstract public function getMethod();

    private function load(array $fields)
    {
        foreach ($fields as $field => $value) {
            $this->{$field} = $value;
        }
    }
}