<?php

declare(strict_types=1);

namespace PCode\ZadanieJeden\Cron;

use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use PCode\ZadanieJeden\Api\ChangelogMetadataInterface;
use PCode\ZadanieJeden\Provider\ConfigProvider;

class Cleanup
{
    public function __construct(
        private readonly ResourceConnection $resourceConnection,
        private readonly ConfigProvider $configProvider,
        private readonly TimezoneInterface $timezone,
    ) {
    }

    public function execute(): void
    {
        $days = $this->configProvider->getRetentionDays();

        $nowDateTime = $this->timezone->date();
        $thresholdDateTime = $nowDateTime
            ->modify(sprintf('-%d days', $days))
            ->format('Y-m-d H:i:s');

        $connection = $this->resourceConnection->getConnection();
        $table = $this->resourceConnection->getTableName(
            ChangelogMetadataInterface::TABLE_NAME,
        );
        $connection->delete(
            $table,
            [
                'changed_at < ?' => $thresholdDateTime,
            ],
        );
    }
}
