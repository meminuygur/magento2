<?php

namespace Magefly\Payment\Model\Ui\Isbank;

use Magefly\Payment\Gateway\Config\Config;
use Magento\Checkout\Model\ConfigProviderInterface;
use Magento\Framework\View\Asset\Source;
use Magento\Payment\Model\CcConfig;

class ConfigProvider implements ConfigProviderInterface
{
    const CODE = 'mageflypayment_isbank';

    /**
     * @var Config
     */
    private Config $config;

    /**
     * @var CcConfig
     */
    private CcConfig $ccConfig;

    /**
     * @var Source
     */
    private Source $assetSource;

    /**
     * ConfigProvider constructor.
     * @param Config $config
     * @param CcConfig $ccConfig
     * @param Source $assetSource
     */
    public function __construct(
        Config $config,
        CcConfig $ccConfig,
        Source $assetSource
    ) {
        $this->config = $config;
        $this->ccConfig = $ccConfig;
        $this->assetSource = $assetSource;
    }

    /**
     * @inheritDoc
     */
    public function getConfig(): array
    {
        $config = [
            'payment' => [
                self::CODE => [
                    'isActive' => $this->config->isActive(),
                    'availableCardTypes' => ['AE', 'VI', 'MC'],
                    'useCvv' => $this->config->isCvvEnabled(),
                    'environment' => 'test',
                    'hasFraudProtection' => true,
                    'merchantId' => 321312,
                ]
            ]
        ];
        return $config;
    }

}
