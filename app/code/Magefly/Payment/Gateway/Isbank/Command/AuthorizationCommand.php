<?php

namespace Magefly\Payment\Gateway\Isbank\Command;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\State\InvalidTransitionException;
use Magento\Payment\Gateway\Command;
use Magento\Payment\Gateway\Command\ResultInterface;
use Magento\Payment\Gateway\CommandInterface;
use Magento\Payment\Gateway\Data\PaymentDataObjectInterface;
use Magento\Payment\Helper\Formatter;
use Magento\Paypal\Model\Payflow\Transparent;

class AuthorizationCommand implements CommandInterface{

    public function execute(array $commandSubject)
    {
        ray($commandSubject);
        // TODO: Implement execute() method.
    }
}
