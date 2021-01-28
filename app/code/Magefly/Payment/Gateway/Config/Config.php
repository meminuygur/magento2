<?php
namespace Magefly\Payment\Gateway\Config;

class Config extends \Magento\Payment\Gateway\Config\Config
{

    public function isActive()
    {
        return true;
    }

    public function isCvvEnabled()
    {
        return true;
    }
}
