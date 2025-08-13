<?php

declare(strict_types=1);

namespace PCode\ZadanieJeden\Setup\Patch\Data;

use Magento\Catalog\Model\Product;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchRevertableInterface;
use Magento\Framework\Validator\ValidateException;
use PCode\ZadanieJeden\Api\CustomSkuMetadataInterface;

class AddCustomSkuAttribute implements DataPatchInterface, PatchRevertableInterface
{
    public function __construct(
        private readonly ModuleDataSetupInterface $moduleDataSetup,
        private readonly EavSetupFactory $eavSetupFactory,
    ) {
    }

    /**
     * @throws LocalizedException
     * @throws ValidateException
     */
    public function apply(): void
    {
        $this->moduleDataSetup->getConnection()->startSetup();
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);
        $eavSetup->addAttribute(
            Product::ENTITY,
            CustomSkuMetadataInterface::PRODUCT_ATTRIBUTE_CODE,
            [
                'type' => 'varchar',
                'input' => 'text',
                'label' => 'Custom SKU',
                'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                'group' => 'General',
                'required' => false,
                'user_defined' => true,
                'searchable' => false,
                'filterable' => false,
                'comparable' => false,
                'visible_on_front' => false,
                'used_in_product_listing' => false,
                'is_used_in_grid' => true,
                'is_visible_in_grid' => true,
                'is_filterable_in_grid' => true,
            ],
        );
        $this->moduleDataSetup->getConnection()->endSetup();
    }

    public function revert(): void
    {
        $this->moduleDataSetup->getConnection()->startSetup();
        $eavSetup = $this->eavSetupFactory->create(
            ['setup' => $this->moduleDataSetup],
        );
        $eavSetup->removeAttribute(
            Product::ENTITY,
            CustomSkuMetadataInterface::PRODUCT_ATTRIBUTE_CODE,
        );
        $this->moduleDataSetup->getConnection()->endSetup();
    }

    public static function getDependencies(): array
    {
        return [];
    }

    public function getAliases(): array
    {
        return [];
    }
}
