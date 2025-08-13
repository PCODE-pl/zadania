<?php

declare(strict_types=1);

namespace PCode\ZadanieDwa\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use PCode\ZadanieDwa\Api\NoteRepositoryInterface;

class NoteUpdateOrderIdObserver implements ObserverInterface
{
    public function __construct(
        private readonly NoteRepositoryInterface $noteRepository,
    ) {
    }

    public function execute(Observer $observer): void
    {
        $order = $observer->getEvent()->getOrder();
        if (!$order->getId()) {
            return;
        }

        try {
            $note = $this
                ->noteRepository
                ->getByQuoteId((int) $order->getQuoteId());
        } catch (NoSuchEntityException) {
            return;
        }
        $note->setOrderId((int) $order->getId());

        $this->noteRepository->save($note);
    }
}
