<?php

declare(strict_types=1);

namespace PCode\ZadanieJeden\Model\ResourceModel\Changelog;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use PCode\ZadanieJeden\Model\Changelog;
use PCode\ZadanieJeden\Model\ResourceModel\Changelog as ChangelogResource;

class Collection extends AbstractCollection
{
    protected function _construct(): void
    {
        $this->_init(
            Changelog::class,
            ChangelogResource::class,
        );
    }
}
