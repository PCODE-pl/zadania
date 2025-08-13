<?php

declare(strict_types=1);

namespace PCode\ZadanieDwa\Model;

use Exception;
use InvalidArgumentException;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Api\SearchResultsInterfaceFactory;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use PCode\ZadanieDwa\Api\Data\NoteInterface;
use PCode\ZadanieDwa\Api\Data\NoteInterfaceFactory;
use PCode\ZadanieDwa\Api\NoteRepositoryInterface;
use PCode\ZadanieDwa\Model\ResourceModel\Note as NoteResource;
use PCode\ZadanieDwa\Model\ResourceModel\Note\CollectionFactory as NoteCollectionFactory;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class NoteRepository implements NoteRepositoryInterface
{
    public function __construct(
        private readonly NoteCollectionFactory $noteCollectionFactory,
        private readonly NoteResource $resource,
        private readonly SearchResultsInterfaceFactory $searchResultsFactory,
        private readonly CollectionProcessorInterface $collectionProcessor,
        private readonly NoteInterfaceFactory $noteFactory,
    ) {
    }

    /**
     * @throws CouldNotSaveException
     */
    public function save(NoteInterface $note): NoteInterface
    {
        try {
            $this->resource->save($note);
        } catch (Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save note: %1',
                $exception->getMessage(),
            ));
        }

        return $note;
    }

    /**
     * @throws NoSuchEntityException
     */
    public function get(int $noteId): NoteInterface
    {
        $note = $this->noteFactory->create();
        $this->resource->load($note, $noteId);
        if (!$note->getId()) {
            throw new NoSuchEntityException(
                __('Note with ID "%1" does not exist.', $noteId),
            );
        }

        return $note;
    }

    /**
     * @throws NoSuchEntityException
     */
    public function getByQuoteId(int $quoteId): NoteInterface
    {
        $note = $this->noteFactory->create();
        $this->resource->load($note, $quoteId, NoteInterface::QUOTE_ID);
        if (!$note->getId()) {
            throw new NoSuchEntityException(
                __('Note with Quote ID "%1" does not exist.', $quoteId),
            );
        }

        return $note;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function getList(
        SearchCriteriaInterface $searchCriteria,
    ): SearchResultsInterface {
        $collection = $this->noteCollectionFactory->create();
        $this->collectionProcessor->process(
            $searchCriteria,
            $collection,
        );
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);

        $items = [];
        foreach ($collection as $item) {
            $items[] = $item;
        }

        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }

    /**
     * @throws CouldNotDeleteException
     */
    public function delete(NoteInterface $note): bool
    {
        try {
            $noteObject = $this->noteFactory->create();
            $this->resource->load(
                $noteObject,
                $note->getNoteId(),
            );
            $this->resource->delete($noteObject);
        } catch (Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete note: %1',
                $exception->getMessage(),
            ));
        }

        return true;
    }

    /**
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById(int $noteId): bool
    {
        return $this->delete($this->get($noteId));
    }
}
