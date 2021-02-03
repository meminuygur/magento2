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

    /**
     * @return bool
     */
    public function isSandbox()
    {
        return ($this->getValue('environment') === 'sandbox');
    }

    /**
     * @return string|null
     */
    public function getEndpointUrl()
    {
        return $this->getEnvValue('endpoint');
    }

    /**
     * @return string|null
     */
    public function getClientId()
    {
        return $this->getEnvValue('client_id');
    }

    /**
     * @return string|null
     */
    public function getClientPassword()
    {
        return $this->getEnvValue('client_password');
    }

    /**
     * @return string|null
     */
    public function getClientUserName()
    {
        return $this->getEnvValue('client_username');
    }

    /**
     * @return string|null
     */
    public function getOrderHistoryEndpoint()
    {
        return $this->getEnvValue('order_history_endpoint');
    }

    /**
     * @param string $field
     * @return mixed|null
     */
    protected function getEnvValue(string $field)
    {
        return $this->getValue(\sprintf('%s_%s', $this->getValue('environment'), $field));
    }
}
