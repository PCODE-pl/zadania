<?php

declare(strict_types=1);

namespace PCode\ZadanieDwa\Plugin;

use Magento\Framework\Exception\LocalizedException;
use Magento\Sales\Api\Data\OrderExtensionFactory;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\OrderRepositoryInterface;
use PCode\ZadanieDwa\Api\Data\NoteInterface;
use PCode\ZadanieDwa\Model\ResourceModel\Note\CollectionFactory;

class AddNoteInOrderPlugin
{
    public function __construct(
        private readonly OrderExtensionFactory $extensionFactory,
        private readonly CollectionFactory $collectionFactory,
    ) {
    }

    /**
     * @throws LocalizedException
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterGet(
        OrderRepositoryInterface $subject,
        OrderInterface $order,
    ): OrderInterface {
        $this->addNoteInOrder($order);

        return $order;
    }

    /**
     * @throws LocalizedException
     */
    private function addNoteInOrder(OrderInterface $order): void
    {
        $extensionAttributes = $order->getExtensionAttributes();
        $extensionAttributes = $extensionAttributes ?: $this->extensionFactory->create();

        $note = $this->getNote($order);
        if ($note->getOrderId()) {
            $extensionAttributes->setNote($note);
        }

        $order->setExtensionAttributes($extensionAttributes);
    }

    /**
     * @throws LocalizedException
     */
    private function getNote(OrderInterface $order): NoteInterface
    {
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter(NoteInterface::ORDER_ID, $order->getId());

        return $collection->getFirstItem();
    }
}
