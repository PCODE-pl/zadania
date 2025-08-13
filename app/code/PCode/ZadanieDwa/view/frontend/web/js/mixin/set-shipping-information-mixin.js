define([
    'jquery',
    'mage/utils/wrapper',
    'Magento_Checkout/js/model/quote',
], function ($, wrapper, quote) {
    'use strict';

    return function (setShippingInformationAction) {
        return wrapper.wrap(setShippingInformationAction, function (originalAction, messageContainer) {
            var shippingAddress = quote.shippingAddress();

            const note = $('#custom_order_note').val();
            if (shippingAddress['extension_attributes'] === undefined) {
                shippingAddress['extension_attributes'] = {};
            }
            shippingAddress['extension_attributes']['custom_order_note'] = note;

            return originalAction();
        });
    };
});
