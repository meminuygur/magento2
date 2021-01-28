<?php
namespace Magefly\Payment\Gateway\Config\Isbank;

use Magento\Payment\Gateway\ConfigInterface;

class Config extends \Magento\Payment\Gateway\Config\Config implements ConfigInterface
{

    public function isActive()
    {
        return true;
    }

}
