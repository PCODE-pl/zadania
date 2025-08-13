#!/bin/bash

bin/magento module:enable PCode_ZadanieJeden
bin/magento module:enable PCode_ZadanieDwa
bin/magento setup:upgrade
