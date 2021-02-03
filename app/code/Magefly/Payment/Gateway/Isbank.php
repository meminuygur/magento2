<?php
namespace Magefly\Payment\Gateway;

use Psr\Http\Message\ResponseInterface;

class Isbank extends GatewayAbstract implements PaymentGatewayInterface
{
    const GATEWAY_FIELD_CARD_NUMBER = 'pan';
    const GATEWAY_FIELD_CARD_EXP_MONTH = 'Ecom_Payment_Card_ExpDate_Month';
    const GATEWAY_FIELD_CARD_EXP_YEAR = 'Ecom_Payment_Card_ExpDate_Year';
    const GATEWAY_FIELD_CARD_CVV = 'cv2';
    const GATEWAY_FIELD_CARD_TYPE = 'cardType';
    const GATEWAY_FIELD_CLIENT_ID = 'clientid';
    const GATEWAY_FIELD_AMOUNT = 'amount';
    const GATEWAY_FIELD_ORDER_ID = 'oid';
    const GATEWAY_FIELD_SUCCESS_URL = 'okUrl';
    const GATEWAY_FIELD_FAILED_URL = 'failUrl';
    const GATEWAY_FIELD_RANDOM_TIME = 'rnd';
    const GATEWAY_FIELD_HASH = 'hash';
    const GATEWAY_FIELD_STORE_TYPE = 'storetype';
    const GATEWAY_FIELD_LANGUAGE_CODE = 'lang';
    const GATEWAY_FIELD_AUTH_TYPE = 'islemtipi';

    /**
     * @param $amount
     * @param $currencyCode
     * @param $cardNumber
     * @param $cardExpMonth
     * @param $cardExpYear
     * @param $cardCvv
     * @param $orderId
     * @return PaymentResponseDataObject
     * @throws \Exception
     */
    public function execute($amount, $currencyCode, $cardNumber, $cardExpMonth, $cardExpYear, $cardCvv, $orderId): PaymentResponseDataObject
    {
        $randomNumber   = microtime();
        $hashString     = $this->gatewayConfig->getClientId() . $orderId . $amount . $this->getSuccessResponseUrl() .
                          $this->getFailedResponseUrl() . $randomNumber . $this->gatewayConfig->getClientPassword();
        $hash           = base64_encode(pack('H*', sha1($hashString)));
        $formParams     = [
            self::GATEWAY_FIELD_CARD_NUMBER => $cardNumber,
            self::GATEWAY_FIELD_CARD_CVV => $cardCvv,
            self::GATEWAY_FIELD_CARD_EXP_YEAR => $cardExpYear,
            self::GATEWAY_FIELD_CARD_EXP_MONTH => $cardExpMonth,
            self::GATEWAY_FIELD_CARD_TYPE => $this->getCardTypeByCardNumber($cardNumber),
            self::GATEWAY_FIELD_CLIENT_ID => $this->gatewayConfig->getClientId(),
            self::GATEWAY_FIELD_AMOUNT => $amount,
            self::GATEWAY_FIELD_ORDER_ID => $orderId,
            self::GATEWAY_FIELD_SUCCESS_URL => $this->getSuccessResponseUrl(),
            self::GATEWAY_FIELD_FAILED_URL => $this->getFailedResponseUrl(),
            self::GATEWAY_FIELD_RANDOM_TIME => $randomNumber,
            self::GATEWAY_FIELD_HASH => $hash,
            self::GATEWAY_FIELD_STORE_TYPE => $this->gatewayConfig->getValue('store_type'),
            self::GATEWAY_FIELD_LANGUAGE_CODE => 'en',
            self::GATEWAY_FIELD_AUTH_TYPE => $this->gatewayConfig->getValue('auth_type')
        ];
        //todo config value getter
        $gatewayResponse = $this->curlClient->post($this->gatewayConfig->getEndpointUrl(), ['form_params' => $formParams]);
        $this->checkResultValid($gatewayResponse);

        $secureKey = md5(\implode($formParams));
        $resultData = new PaymentResponseDataObject();
        $resultData->setStatus($resultData::STATUS_3D_SECURE_REQUIRED)
            ->set3dsecureFormKey($secureKey)
            ->set3dsecurePageHtmlContent($gatewayResponse->getBody()->getContents())
            ->setIframeUrl($this->urlBuilder->getUrl('mageflypayment/gateway/redirect', ['key' => $secureKey]));
        return $resultData;
    }

    /**
     * @param ResponseInterface $response
     * @throws \Exception
     */
    private function checkResultValid(ResponseInterface $response)
    {
        if ($response->getStatusCode() !== 200) {
            throw new \Exception('Gateway server response is not valid.');
        }
        if (!$response->getBody()->getSize()) {
            throw new \Exception('Gateway response body is empty.');
        }
    }

    private function getSuccessResponseUrl()
    {
        return $this->urlBuilder->getUrl('mageflypayment/gateway/response');
    }

    private function getFailedResponseUrl()
    {
        return $this->urlBuilder->getUrl('mageflypayment/gateway/response');
    }

    private function getCardTypeByCardNumber($cardNumber)
    {
        return 1; // 2 mastercard
    }
}
