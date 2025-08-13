<?php

declare(strict_types=1);

namespace PCode\ZadanieDwa\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use PCode\ZadanieDwa\Api\NoteMetadataInterface;

class Note extends AbstractDb
{
    protected function _construct()
    {
        $this->_init(
            NoteMetadataInterface::TABLE_NAME,
            NoteMetadataInterface::ID_FIELD_NAME,
        );
    }
}
