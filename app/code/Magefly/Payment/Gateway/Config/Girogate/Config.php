<?php


namespace Magefly\Payment\Gateway\Config\Girogate;


use Magento\Payment\Gateway\ConfigInterface;

class Config extends \Magento\Payment\Gateway\Config\Config implements ConfigInterface
{
    public function isActive()
    {
        return false;
    }
}
