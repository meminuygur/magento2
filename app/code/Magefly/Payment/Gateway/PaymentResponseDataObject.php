<?php

namespace Magefly\Payment\Gateway;

use Magento\Framework\DataObject;

class PaymentResponseDataObject extends DataObject
{
    const STATUS_3D_SECURE_REQUIRED = '3D_SECURE_REQUIRED';
    const STATUS_PREAUTH_SUCCESS = 'PREAUTH_SUCCESS';
    const STATUS_AUTH_SUCCESS = 'AUTH_SUCCESS';
    const STATUS_FAILED = 'FAIL';

    /**
     * @param string $htmlContent
     * @return $this
     */
    public function set3dsecurePageHtmlContent($htmlContent)
    {
        $this->setData('3dsecure_page_html_content', $htmlContent);
        return $this;
    }

    /**
     * @param string $formKey
     * @return $this
     */
    public function set3dsecureFormKey(string $formKey): PaymentResponseDataObject
    {
        $this->setData('3dsecure_form_key', $formKey);
        return $this;
    }

    /**
     * @param string $iframeUrl
     * @return $this
     */
    public function setIframeUrl(string $iframeUrl): PaymentResponseDataObject
    {
        $this->setData('iframe_url', $iframeUrl);
        return $this;
    }

    /**
     * @param $status
     * @return $this
     */
    public function setStatus(string $status): PaymentResponseDataObject
    {
        $this->setData('status', $status);
        return $this;
    }

    /**
     * @return string|null
     */
    public function get3dsecurePageHtmlContent(): ?string
    {
        return $this->getData('3dsecure_page_html_content');
    }

    /**
     * @return string|null
     */
    public function getIframeUrl(): ?string
    {
        return $this->getData('iframe_url');
    }

    /**
     * @return string|null
     */
    public function get3dsecureFormKey(): ?string
    {
        return $this->getData('3dsecure_form_key');
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->getData('status');
    }
}
