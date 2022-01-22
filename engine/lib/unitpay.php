<?php

function upSign($method, $params, $secretKey) {
    ksort($params);
    unset($params['sign']);
    unset($params['signature']);
    array_push($params, $secretKey);
    array_unshift($params, $method);

    return hash('sha256', join('{up}', $params));
}

$method = $_GET['method'];
$params = $_GET['params'];

if ($params == null || $params['signature'] != upSign($method, $params, $tableconf['unitpay']['secret_key'])) {
    exit('{"error": {"message": "Некорректная цифровая подпись"}}');
}

if ($method != 'pay'){
    exit('{"result": {"message":"Запрос успешно обработан [actionCheck]"}}');
}

$payment = new payment();
$status = $payment->checkPayment($_GET['params']['account'], $params['orderSum']);

if ($status !== true) {
    exit('{"error": {"message": "{' . $status . '}"}}');
}

$status = $payment->givePayment();

if ($status !== true) {
    exit('{"error": {"message": "{' . $status . '}"}}');
}

exit('{"result": {"message":"Запрос успешно обработан [actionPay]"}}');