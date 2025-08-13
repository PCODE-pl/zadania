<?php

declare(strict_types=1);

namespace PCode\ZadanieDwa\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface NoteSearchResultsInterface extends SearchResultsInterface
{
    /**
     * @return NoteInterface[]
     */
    public function getItems(): array;

    /**
     * @param array $items
     *
     * @return NoteSearchResultsInterface
     */
    public function setItems(array $items);
}
