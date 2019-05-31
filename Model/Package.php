<?php
/**
 * Package.php
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Aurora Extensions EULA,
 * which is bundled with this package in the file LICENSE.txt.
 *
 * It is also available on the Internet at the following URL:
 * https://docs.auroraextensions.com/magento/extensions/2.x/simplereturns/LICENSE.txt
 *
 * @package       AuroraExtensions_SimpleReturns
 * @copyright     Copyright (C) 2019 Aurora Extensions <support@auroraextensions.com>
 * @license       Aurora Extensions EULA
 */
declare(strict_types=1);

namespace AuroraExtensions\SimpleReturns\Model;

use AuroraExtensions\SimpleReturns\{
    Api\Data\LabelInterface,
    Api\Data\PackageInterface,
    Shared\ModuleComponentInterface
};

use Magento\{
    Framework\Model\AbstractModel,
    Shipping\Model\Carrier\CarrierInterface
};

class Package extends AbstractModel implements
    PackageInterface,
    ModuleComponentInterface
{
    /**
     * @return void
     */
    public function _construct()
    {
        $this->_init(ResourceModel\Package::class);
    }

    /**
     * @return CarrierInterface
     */
    public function getCarrier(): CarrierInterface
    {
        return $this->getData('carrier');
    }

    /**
     * @param CarrierInterface $carrier
     * @return PackageInterface
     */
    public function setCarrier(CarrierInterface $carrier): PackageInterface
    {
        $this->setData('carrier', $carrier);

        return $this;
    }

    /**
     * @return string
     */
    public function getCarrierCode(): string
    {
        return $this->getData('carrier_code');
    }

    /**
     * @param string $code
     * @return PackageInterface
     */
    public function setCarrierCode(string $code): PackageInterface
    {
        $this->setData('carrier_code', $code);

        return $this;
    }

    /**
     * @return string
     */
    public function getContainerType(): string
    {
        return $this->getData('container_type');
    }

    /**
     * @param string $type
     * @return PackageInterface
     */
    public function setContainerType(string $type): PackageInterface
    {
        $this->setData('container_type', $type);

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->getData('description');
    }

    /**
     * @param string $description
     * @return PackageInterface
     */
    public function setDescription(string $description): PackageInterface
    {
        $this->setData('description', $description);

        return $this;
    }

    /**
     * @return string
     */
    public function getDimensionUnits(): string
    {
        return $this->getData('dimension_units');
    }

    /**
     * @param string $units
     * @return PackageInterface
     */
    public function setDimensionUnits(string $units): PackageInterface
    {
        $this->setData('dimension_units', $units);

        return $this;
    }

    /**
     * @return LabelInterface
     */
    public function getLabel(): LabelInterface
    {
        return $this->getData('label');
    }

    /**
     * @param LabelInterface $label
     * @return PackageInterface
     */
    public function setLabel(LabelInterface $label): PackageInterface
    {
        $this->setData('label', $label);

        return $this;
    }

    /**
     * @return float
     */
    public function getWeight(): float
    {
        return $this->getData('weight');
    }

    /**
     * @param float $weight
     * @return PackageInterface
     */
    public function setWeight(float $weight): PackageInterface
    {
        $this->setData('weight', $weight);

        return $this;
    }

    /**
     * @return string
     */
    public function getWeightUnits(): string
    {
        return $this->getData('weight_units');
    }

    /**
     * @param string $units
     * @return PackageInterface
     */
    public function setWeightUnits(string $units): PackageInterface
    {
        $this->setData('weight_units', $units);

        return $this;
    }
}