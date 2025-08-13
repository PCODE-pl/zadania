<?php

declare(strict_types=1);

namespace PCode\ZadanieDwa\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use PCode\ZadanieDwa\Api\Data\NoteInterface;

interface NoteRepositoryInterface
{
    /**
     * @param NoteInterface $note
     * @return NoteInterface
     */
    public function save(NoteInterface $note): NoteInterface;

    /**
     * @param int $noteId
     * @return NoteInterface
     */
    public function get(int $noteId): NoteInterface;

    /**
     * @param int $quoteId
     * @return NoteInterface
     */
    public function getByQuoteId(int $quoteId): NoteInterface;

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): SearchResultsInterface;

    /**
     * @param NoteInterface $note
     * @return bool
     */
    public function delete(NoteInterface $note): bool;

    /**
     * @param int $noteId
     * @return bool
     */
    public function deleteById(int $noteId): bool;
}
