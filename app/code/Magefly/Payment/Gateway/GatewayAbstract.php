<?php
namespace Magefly\Payment\Gateway;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\UrlInterface;
use Magento\Checkout\Model\Session as CheckoutSession;
use Magefly\Payment\Gateway\Config\Config as GatewayConfig;
use Magefly\Payment\Gateway\Exception\PaymentGatewayNotFoundException;
use GuzzleHttp\Client;

class GatewayAbstract
{

    /**
     * @var ResultFactory
     */
    protected $resultFactory;

    /**
     * @var ResponseInterface
     */
    protected $response;

    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var Client
     */
    protected $curlClient;

    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * @var CheckoutSession
     */
    protected $checkoutSession;

    /**
     * @var GatewayConfig
     */
    protected $gatewayConfig;

    /**
     * @var PaymentGatewayInterface
     */
    private $paymentGateway;

    /**
     * GatewayAbstract constructor.
     * @param Client $client
     * @param UrlInterface $urlBuilder
     * @param CheckoutSession $checkoutSession
     * @param GatewayConfig $gatewayConfig
     */
    public function __construct(
        Client $client,
        UrlInterface $urlBuilder,
        CheckoutSession $checkoutSession,
        GatewayConfig $gatewayConfig
    ) {
        $this->curlClient = $client;
        $this->urlBuilder = $urlBuilder;
        $this->checkoutSession = $checkoutSession;
        $this->gatewayConfig = $gatewayConfig;
    }

    /**
     * @param string $paymentMethod ex: mageflypayment_isbank
     * @return GatewayAbstract
     * @throws PaymentGatewayNotFoundException
     */
    public function setPaymentGateway(string $paymentMethod) : GatewayAbstract
    {

        if (strpos($paymentMethod, '_') !== false) {
            $paymentGateway = explode('_', $paymentMethod);
            $paymentGateway = 'Magefly\Payment\Gateway\\' . \ucfirst($paymentGateway[1]);
            if (!\class_exists($paymentGateway)) {
                throw new PaymentGatewayNotFoundException(__('Payment gateway class not found : %s', $paymentGateway));
            }
            $this->gatewayConfig->setMethodCode($paymentMethod);
            $this->paymentGateway = $paymentGateway;
            return $this;
        }
        throw new PaymentGatewayNotFoundException(__('Payment method should contain \'_\' : %s', $paymentMethod));
    }

    /**
     * @param float $amount
     * @param string $currencyCode
     * @param string $cardNumber
     * @param string $cardExpMonth
     * @param string $cardExpYear
     * @param string $cardCvv
     * @param string $orderId
     * @return PaymentResponseDataObject
     * @throws \Exception
     */
    public function pay($amount, string $currencyCode, string $cardNumber, string $cardExpMonth, string $cardExpYear, string $cardCvv, string $orderId): PaymentResponseDataObject
    {
        /** @var PaymentGatewayInterface $paymentGateway */
        $paymentGateway = new $this->paymentGateway($this->curlClient, $this->urlBuilder, $this->checkoutSession, $this->gatewayConfig);
        return $paymentGateway->execute($amount, $currencyCode, $cardNumber, $cardExpMonth, $cardExpYear, $cardCvv, $orderId);
    }
}
