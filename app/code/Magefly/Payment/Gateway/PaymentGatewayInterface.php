<?php

namespace Magefly\Payment\Gateway;

interface PaymentGatewayInterface
{

    public function execute($amount, $currencyCode, $cardNumber, $cardExpMonth, $cardExpYear, $cardCvv, $orderId): PaymentResponseDataObject;
}
