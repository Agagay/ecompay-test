<?php
//date_default_timezone_set('Europe/Moscow');
//$apiKey = 'daef4ff758859227ac5ff22b3d73e090';
//$currency = 'EUR';
//$amount = 300200;
//$referenceNo = 123;
//$dateTime = new DateTime();
//$timestamp = $dateTime->getTimestamp();
//$secretKey = 'f07fce0a';
//
//$params = ['apiKey' => $apiKey, 'amount' => $amount, 'currency' => $currency, 'referenceNo' => $referenceNo, 'timestamp' => $timestamp];
//
//function generateToken($request, $secretKey)
//{
//    $rawHash = $secretKey . $request['apiKey'] . $request['amount'] . $request['currency'] .
//        $request['referenceNo'] . $request['timestamp'];
//    return md5($rawHash);
//}
//
//print_r($timestamp);echo '<br>';
//print_r($dateTime);echo '<br>';
//print_r(generateToken($params, $secretKey));
//
//die();

use App\Kernel;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\ErrorHandler\Debug;
use Symfony\Component\HttpFoundation\Request;

require dirname(__DIR__).'/vendor/autoload.php';

(new Dotenv())->bootEnv(dirname(__DIR__).'/.env');

if ($_SERVER['APP_DEBUG']) {
    umask(0000);

    Debug::enable();
}

if ($trustedProxies = $_SERVER['TRUSTED_PROXIES'] ?? false) {
    Request::setTrustedProxies(explode(',', $trustedProxies), Request::HEADER_X_FORWARDED_ALL ^ Request::HEADER_X_FORWARDED_HOST);
}

if ($trustedHosts = $_SERVER['TRUSTED_HOSTS'] ?? false) {
    Request::setTrustedHosts([$trustedHosts]);
}

$kernel = new Kernel($_SERVER['APP_ENV'], (bool)$_SERVER['APP_DEBUG']);
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
