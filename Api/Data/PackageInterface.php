<?php
/**
 * PackageInterface.php
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT License, which
 * is bundled with this package in the file LICENSE.txt.
 *
 * It is also available on the Internet at the following URL:
 * https://docs.auroraextensions.com/magento/extensions/2.x/simplereturns/LICENSE.txt
 *
 * @package        Tmo_SimpleReturns
 * @copyright      Copyright (C) 2019 Aurora Extensions <support@auroraextensions.com>
 * @license        MIT License
 */
declare(strict_types=1);

namespace Tmo\SimpleReturns\Api\Data;

use Magento\Shipping\Model\Carrier\CarrierInterface;

interface PackageInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @param int $id
     * @return \Tmo\SimpleReturns\Api\Data\PackageInterface
     */
    public function setId($id);

    /**
     * @return string
     */
    public function getCreatedAt();

    /**
     * @param string $createdAt
     * @return \Tmo\SimpleReturns\Api\Data\PackageInterface
     */
    public function setCreatedAt($createdAt);

    /**
     * @return CarrierInterface|null
     */
    public function getCarrier(): ?CarrierInterface;

    /**
     * @param CarrierInterface $carrier
     * @return \Tmo\SimpleReturns\Api\Data\PackageInterface
     */
    public function setCarrier(CarrierInterface $carrier): PackageInterface;

    /**
     * @return string
     */
    public function getCarrierCode(): string;

    /**
     * @param string $code
     * @return \Tmo\SimpleReturns\Api\Data\PackageInterface
     */
    public function setCarrierCode(string $code): PackageInterface;

    /**
     * @return string
     */
    public function getContainerType(): string;

    /**
     * @param string $type
     * @return \Tmo\SimpleReturns\Api\Data\PackageInterface
     */
    public function setContainerType(string $type): PackageInterface;

    /**
     * @return string
     */
    public function getDescription(): string;

    /**
     * @param string $description
     * @return \Tmo\SimpleReturns\Api\Data\PackageInterface
     */
    public function setDescription(string $description): PackageInterface;

    /**
     * @return string
     */
    public function getDimensionUnits(): string;

    /**
     * @param string $units
     * @return \Tmo\SimpleReturns\Api\Data\PackageInterface
     */
    public function setDimensionUnits(string $units): PackageInterface;

    /**
     * @return LabelInterface
     */
    public function getLabel(): LabelInterface;

    /**
     * @param LabelInterface $label
     * @return \Tmo\SimpleReturns\Api\Data\PackageInterface
     */
    public function setLabel(LabelInterface $label): PackageInterface;

    /**
     * @return float
     */
    public function getWeight(): float;

    /**
     * @param float $weight
     * @return \Tmo\SimpleReturns\Api\Data\PackageInterface
     */
    public function setWeight(float $weight): PackageInterface;

    /**
     * @return string
     */
    public function getWeightUnits(): string;

    /**
     * @param string $units
     * @return \Tmo\SimpleReturns\Api\Data\PackageInterface
     */
    public function setWeightUnits(string $units): PackageInterface;
}
