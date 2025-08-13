<?php

declare(strict_types=1);

namespace PCode\ZadanieJeden\Ui\DataProvider\ChangeLog;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Ui\DataProvider\AbstractDataProvider;
use PCode\ZadanieJeden\Model\ResourceModel\Changelog\Grid\CollectionFactory;

class Form extends AbstractDataProvider
{
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        private readonly ProductRepositoryInterface $productRepository,
        array $meta = [],
        array $data = [],
    ) {
        parent::__construct(
            $name,
            $primaryFieldName,
            $requestFieldName,
            $meta,
            $data,
        );
        $this->collection = $collectionFactory->create();
    }

    public function getData()
    {
        $data = parent::getData();

        if ($data['totalRecords'] > 0) {
            $changeLogId = (int) $data['items'][0]['entity_id'];
            $data[$changeLogId]['changelog_entry'] = $data['items'][0];

            $productId = (int) $data['items'][0]['product_id'];
            try {
                $product = $this->productRepository->getById($productId);
                $productSku = $product->getSku();
                $productName = $product->getName();
            } catch (NoSuchEntityException) {
                $productSku = '<not found>';
                $productName = '<not found>';
            }

            $data[$changeLogId]['changelog_entry']['sku'] = $productSku;
            $data[$changeLogId]['changelog_entry']['product_name'] = $productName;
        }

        return $data;
    }
}
