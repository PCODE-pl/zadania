<?php

declare(strict_types=1);

namespace PCode\ZadanieJeden\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use PCode\ZadanieJeden\Api\ChangelogMetadataInterface;

class Changelog extends AbstractDb
{
    protected function _construct()
    {
        $this->_init(
            ChangelogMetadataInterface::TABLE_NAME,
            ChangelogMetadataInterface::ID_FIELD_NAME,
        );
    }
}
