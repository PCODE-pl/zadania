<?php

declare(strict_types=1);

namespace PCode\ZadanieJeden\Observer;

use InvalidArgumentException;
use Magento\Backend\Model\Auth\Session as AdminSession;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\ResourceModel\Product as ProductResource;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Store\Model\Store;
use PCode\ZadanieJeden\Api\ChangelogMetadataInterface;
use PCode\ZadanieJeden\Api\CustomSkuMetadataInterface;
use PCode\ZadanieJeden\Api\Data\ChangeLogInterface;

/**
 * @SuppressWarnings(PHPMD.CookieAndSessionMisuse)
 */
class LogCustomSkuChangeObserver implements ObserverInterface
{
    public function __construct(
        private readonly ResourceConnection $resourceConnection,
        private readonly ProductResource $productResource,
        private readonly AdminSession $adminSession,
    ) {
    }

    /**
     * @throws InvalidArgumentException
     */
    public function execute(Observer $observer): void
    {
        /** @var Product $product */
        $product = $observer->getEvent()->getProduct();
        if (!$product) {
            return;
        }

        $oldValue = $this->getOldValue($product);
        $newValue = $this->getNewValue($product);
        if ($oldValue !== $newValue) {
            $this->logChange(
                $product,
                $oldValue,
                $newValue,
            );
        }
    }

    private function getOldValue(Product $product): string
    {
        $result = $this->productResource->getAttributeRawValue(
            (int) $product->getId(),
            CustomSkuMetadataInterface::PRODUCT_ATTRIBUTE_CODE,
            Store::DEFAULT_STORE_ID,
        );

        return $result === [] ? '' : (string) $result;
    }

    private function getNewValue(Product $product): string
    {
        return $product->getData(CustomSkuMetadataInterface::PRODUCT_ATTRIBUTE_CODE) ?: '';
    }

    /**
     * @throws InvalidArgumentException
     */
    private function logChange(
        Product $product,
        string $oldValue,
        string $newValue,
    ): void {
        $adminUserId = null;
        $user = $this->adminSession->getUser();
        if ($user && $user->getId()) {
            $adminUserId = (int) $user->getId();
        }

        $connection = $this->resourceConnection->getConnection();
        $table = $this->resourceConnection->getTableName(
            ChangelogMetadataInterface::TABLE_NAME,
        );
        $connection->insert(
            $table,
            [
                ChangeLogInterface::PRODUCT_ID => (int) $product->getId(),
                ChangeLogInterface::OLD_VALUE => $oldValue,
                ChangeLogInterface::NEW_VALUE => $newValue,
                ChangeLogInterface::ADMIN_USER_ID => $adminUserId,
            ],
        );
    }
}
