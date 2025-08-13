<?php

declare(strict_types=1);

namespace PCode\ZadanieJeden\Model;

use Magento\Framework\Model\AbstractModel;
use PCode\ZadanieJeden\Model\ResourceModel\Changelog as ChangelogResource;

class Changelog extends AbstractModel
{
    protected function _construct(): void
    {
        $this->_init(ChangelogResource::class);
    }
}
