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

        nl2br: function (str, is_xhtml) {
            if (typeof str === 'undefined' || str === null) {
                return '';
            }
            var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';

            return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
        },

        /**
         * @return {String}
         */
        getNote: function () {
            return this.nl2br($('#custom_order_note').val(), true);
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
