/*browser:true*/
/*global define*/
define(
    [
        'uiComponent',
        'Magento_Checkout/js/model/payment/renderer-list'
    ],
    function (
        Component,
        rendererList
    ) {
        'use strict';

        let config = window.checkoutConfig.payment,
            mageflypaymentIsbank = 'mageflypayment_isbank',
            mageflypaymentGirogate = 'mageflypayment_girogate';
        console.log(config);
        if (config[mageflypaymentIsbank].isActive) {
            rendererList.push(
                {
                    type: mageflypaymentIsbank,
                    component: 'Magefly_Payment/js/view/payment/method-renderer/isbank'
                }
            );
        }

        if (config[mageflypaymentGirogate].isActive) {
            rendererList.push(
                {
                    type: mageflypaymentGirogate,
                    component: 'Magefly_Payment/js/view/payment/method-renderer/girogate'
                }
            );
        }

        /** Add view logic here if needed */
        return Component.extend({});
    }
);
