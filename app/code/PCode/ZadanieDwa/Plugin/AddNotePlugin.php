<?php

declare(strict_types=1);

namespace PCode\ZadanieDwa\Plugin;

use Magento\Checkout\Api\Data\ShippingInformationInterface;
use Magento\Checkout\Model\ShippingInformationManagement;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Filter\FilterManager;
use Magento\Quote\Api\CartRepositoryInterface;
use PCode\ZadanieDwa\Api\NoteRepositoryInterface;
use PCode\ZadanieDwa\Api\Data\NoteInterface;
use PCode\ZadanieDwa\Api\Data\NoteInterfaceFactory;

class AddNotePlugin
{
    public function __construct(
        private readonly CartRepositoryInterface $quoteRepository,
        private readonly NoteInterfaceFactory $noteFactory,
        private readonly NoteRepositoryInterface $noteRepository,
        private readonly FilterManager $filterManager,
    ) {
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function beforeSaveAddressInformation(
        ShippingInformationManagement $subject,
        int $cartId,
        ShippingInformationInterface $addressInformation,
    ): void {
        $address = $addressInformation->getShippingAddress();
        $extensionAttributes = $address->getExtensionAttributes();
        if ($extensionAttributes?->getCustomOrderNote()) {
            $quote = $this->quoteRepository->getActive($cartId);
            $quoteId = (int)$quote->getId();
            if ($quoteId) {
                $noteText = $this->prepareNote($extensionAttributes->getCustomOrderNote());
                $note = $this->getNote($quoteId);
                $note->setQuoteId($quoteId);
                $note->setNote($noteText);
                $this->noteRepository->save($note);
            }
        }
    }

    private function getNote(int $quoteId): NoteInterface
    {
        try {
            return $this->noteRepository->getByQuoteId($quoteId);
        } catch (NoSuchEntityException) {
            return $this->noteFactory->create();
        }
    }

    private function prepareNote(string $note): string
    {
        return $this->filterManager->stripTags(trim($note));
    }
}
