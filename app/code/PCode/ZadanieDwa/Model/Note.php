<?php

declare(strict_types=1);

namespace PCode\ZadanieDwa\Model;

use Magento\Framework\Model\AbstractModel;
use PCode\ZadanieDwa\Api\Data\NoteInterface;
use PCode\ZadanieDwa\Model\ResourceModel\Note as NoteResource;

class Note extends AbstractModel implements NoteInterface
{
    protected function _construct(): void
    {
        $this->_init(NoteResource::class);
    }

    public function getNoteId(): ?int
    {
        $result = $this->getData(self::ID);
        if (null === $result) {
            return null;
        }

        return (int) $result;
    }

    public function setNoteId(int $noteId): void
    {
        $this->setData(self::ID, $noteId);
    }

    public function getQuoteId(): int
    {
        return (int) $this->getData(self::QUOTE_ID);
    }

    public function setQuoteId(int $quoteId): void
    {
        $this->setData(self::QUOTE_ID, $quoteId);
    }

    public function getOrderId(): ?int
    {
        $result = $this->getData(self::ORDER_ID);
        if (!$result) {
            return null;
        }

        return (int) $result;
    }

    public function setOrderId(int $orderId): void
    {
        $this->setData(self::ORDER_ID, $orderId);
    }

    public function getNote(): ?string
    {
        return $this->getData(self::NOTE);
    }

    public function setNote(string $note): void
    {
        $this->setData(self::NOTE, $note);
    }
}
