<?php


namespace App\DepKasa\Request;


use App\DepKasa\DepKasa;

class WelcomeRequest extends BaseRequest
{
    public $token;
    public $timestamp;
    public $email;
    public $birthday;
    public $amount;
    public $currency;
    public $returnUrl;
    public $referenceNo;
    public $language;
    public $billingFirstName;
    public $billingLastName;
    public $billingAddress1;
    public $billingCity;
    public $billingPostcode;
    public $billingCountry;
    public $paymentMethod;
    public $number;
    public $cvv;
    public $expiryMonth;
    public $expiryYear;
    public $callbackUrl;

    public function getMethod()
    {
        return 'payment/welcome';
    }

    public function __construct(array $fields)
    {
        $this->timestamp = time();
        $this->token = DepKasa::generateWelcomeToken(
            $fields['amount'],
            $fields['currency'],
            $fields['referenceNo'],
            $this->timestamp
        );

        parent::__construct($fields);
    }
}