<?php

declare(strict_types=1);

namespace PCode\ZadanieJeden\Provider;

use Magento\Framework\App\Config\ScopeConfigInterface;

class ConfigProvider
{
    private const XML_PATH_BASE = 'pcode_zadaniejeden';
    private const XML_PATH_RETENTION = self::XML_PATH_BASE.'/general/retention_days';
    private const DEFAULT_RETENTION_DAYS = 30;

    public function __construct(
        private readonly ScopeConfigInterface $scopeConfig,
    ) {
    }

    public function getRetentionDays(): int
    {
        $result = (int) ($this->scopeConfig->getValue(self::XML_PATH_RETENTION) ?: self::DEFAULT_RETENTION_DAYS);
        if ($result < 1) {
            $result = self::DEFAULT_RETENTION_DAYS;
        }

        return $result;
    }
}
