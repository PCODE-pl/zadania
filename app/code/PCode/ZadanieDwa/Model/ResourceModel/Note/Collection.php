<?php

declare(strict_types=1);

namespace PCode\ZadanieDwa\Model\ResourceModel\Note;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use PCode\ZadanieDwa\Model\Note;
use PCode\ZadanieDwa\Model\ResourceModel\Note as NoteResource;

class Collection extends AbstractCollection
{
    protected function _construct(): void
    {
        $this->_init(
            Note::class,
            NoteResource::class,
        );
    }
}
