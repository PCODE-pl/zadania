#!/bin/bash

# Install external modules
composer require "markshust/magento2-module-disabletwofactorauth":"^2.0"

# Enable our modules
bin/magento module:enable PCode_ZadanieJeden
bin/magento module:enable PCode_ZadanieDwa

# Final steps
bin/magento setup:upgrade
bin/magento catalog:images:resize
bin/magento indexer:reindex
bin/magento cache:flush
