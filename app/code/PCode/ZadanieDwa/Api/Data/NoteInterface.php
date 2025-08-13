<?php

declare(strict_types=1);

namespace PCode\ZadanieDwa\Api\Data;

interface NoteInterface
{
    public const ID = 'entity_id';
    public const QUOTE_ID = 'quote_id';
    public const ORDER_ID = 'order_id';
    public const NOTE = 'note';

    /**
     * @return int|null
     */
    public function getNoteId(): ?int;

    /**
     * @param int $noteId
     * @return void
     */
    public function setNoteId(int $noteId): void;

    /**
     * @return int
     */
    public function getQuoteId(): int;

    /**
     * @param int $quoteId
     * @return void
     */
    public function setQuoteId(int $quoteId): void;

    /**
     * @return int|null
     */
    public function getOrderId(): ?int;

    /**
     * @param int $orderId
     * @return void
     */
    public function setOrderId(int $orderId): void;

    /**
     * @return string|null
     */
    public function getNote(): ?string;

    /**
     * @param string $note
     * @return void
     */
    public function setNote(string $note): void;
}
