<?php


namespace App\DepKasa;


use App\DepKasa\Request\BaseRequest;
use App\DepKasa\Request\DetailRequest;
use App\DepKasa\Request\WelcomeRequest;
use App\DepKasa\Response\BaseResponse;
use App\DepKasa\Response\DetailResponse;
use App\DepKasa\Response\WelcomeResponse;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class DepKasa
{
    const API_URL = 'https://mock01.ecpdss.net/depkasa/a/';
    const API_KEY = 'daef4ff758859227ac5ff22b3d73e090';
    const SECRET = 'f07fce0a';

    private $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    private function makeUrl(BaseRequest $request)
    {
        return self::API_URL . $request->getMethod();
    }

    private function post(string $url, array $parameters = [])
    {
        $data = [
            'query' => array_merge($parameters, ['apiKey' => self::API_KEY]),
        ];
        return $this->httpClient->request('POST', $url, $data);
    }

    public static function generateWelcomeToken($amount, $currency, $paymentId, $timestamp)
    {
        $rawHash = self::SECRET . self::API_KEY . $amount . $currency .
            $paymentId . $timestamp;

        return md5($rawHash);
    }

    public static function generateCallbackToken($code, $status, $amount, $currency, $referenceNo, $timestamp)
    {
        $rawHash = self::SECRET . self::API_KEY . $code . $status .
            $amount .$currency . $referenceNo . $timestamp;

        return md5($rawHash);
    }

    public function welcome(WelcomeRequest $request, WelcomeResponse $response)
    {
        $result = $this->post($this->makeUrl($request), (array)$request);
        return $response->parseResponse(json_decode($result->getContent(), true));
    }

    public function detail(DetailRequest $request, DetailResponse $response)
    {
        $result = $this->post($this->makeUrl($request), (array)$request);
        return $response->parseResponse(json_decode($result->getContent(), true));
    }
}