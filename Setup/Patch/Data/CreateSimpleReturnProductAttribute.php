<?php
/**
 * CreateSimpleReturnProductAttribute.php
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT License, which
 * is bundled with this package in the file LICENSE.txt.
 *
 * It is also available on the Internet at the following URL:
 * https://docs.auroraextensions.com/magento/extensions/2.x/simplereturns/LICENSE.txt
 *
 * @package       Tmo_SimpleReturns
 * @copyright     Copyright (C) 2019 Aurora Extensions <support@auroraextensions.com>
 * @license       MIT License
 */
declare(strict_types=1);

namespace Tmo\SimpleReturns\Setup\Patch\Data;

use Tmo\SimpleReturns\Shared\ModuleComponentInterface;
use Magento\{
    Catalog\Model\Product,
    Eav\Model\Entity\Attribute\ScopedAttributeInterface,
    Eav\Model\Entity\Attribute\Source\Boolean as SourceBoolean,
    Eav\Setup\EavSetupFactory,
    Framework\Setup\ModuleDataSetupInterface,
    Framework\Setup\Patch\DataPatchInterface,
    Framework\Setup\Patch\PatchRevertableInterface
};

class CreateSimpleReturnProductAttribute implements
    DataPatchInterface,
    PatchRevertableInterface,
    ModuleComponentInterface
{
    /** @property EavSetupFactory $eavSetupFactory */
    protected $eavSetupFactory;

    /** @property ModuleDataSetupInterface $moduleDataSetup */
    protected $moduleDataSetup;

    /**
     * @param EavSetupFactory $eavSetupFactory
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @return void
     */
    public function __construct(
        EavSetupFactory $eavSetupFactory,
        ModuleDataSetupInterface $moduleDataSetup
    ) {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->moduleDataSetup = $moduleDataSetup;
    }

    /**
     * {@inheritdoc}
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function apply()
    {
        /** @var EavSetup $eavSetup */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);

        $eavSetup->addAttribute(
            Product::ENTITY,
            static::ATTRIBUTE_CODE_SIMPLE_RETURN,
            [
                'type'             => 'int',
                'input'            => 'boolean',
                'label'            => static::ATTRIBUTE_LABEL_SIMPLE_RETURN,
                'global'           => ScopedAttributeInterface::SCOPE_GLOBAL,
                'frontend'         => '',
                'source'           => SourceBoolean::class,
                'visible'          => true,
                'required'         => false,
                'user_defined'     => true,
                'default'          => 0,
                'searchable'       => false,
                'filterable'       => false,
                'comparable'       => false,
                'visible_on_front' => false,
                'unique'           => false,
                'apply_to'         => '',
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function revert()
    {
        /** @var EavSetup $eavSetup */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);

        $eavSetup->removeAttribute(
            Product::ENTITY,
            static::ATTRIBUTE_CODE_SIMPLE_RETURN
        );
    }
}
