define([
    'jquery',
    'uiComponent',
    'Magento_Checkout/js/model/quote',
    'Magento_Checkout/js/model/step-navigator',
    'Magento_Checkout/js/model/sidebar',
], function ($, Component, quote, stepNavigator, sidebarModel) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'PCode_ZadanieDwa/sidebar-note'
        },

        /**
         * @return {String}
         */
        getNote: function () {
            return $('#custom_order_note').val();
        },

        /**
         * @return {Boolean}
         */
        isVisible: function () {
            const note = this.getNote();

            return !quote.isVirtual()
                && stepNavigator.isProcessed('shipping')
                && note && note.trim() !== ''
            ;
        },

        /**
         * Back step.
         */
        back: function () {
            sidebarModel.hide();
            stepNavigator.navigateTo('shipping');
        },
    });
});
