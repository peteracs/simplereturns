<?php
/**
 * LabelInterface.php
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

interface LabelInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @param int $id
     * @return \Tmo\SimpleReturns\Api\Data\LabelInterface
     */
    public function setId($id);

    /**
     * @return string
     */
    public function getCreatedAt();

    /**
     * @param string $createdAt
     * @return \Tmo\SimpleReturns\Api\Data\LabelInterface
     */
    public function setCreatedAt($createdAt);

    /**
     * @return string|null
     */
    public function getImage(): ?string;

    /**
     * @param string|null $image
     * @return \Tmo\SimpleReturns\Api\Data\LabelInterface
     */
    public function setImage(?string $image): LabelInterface;

    /**
     * @return string
     */
    public function getTrackingNumber(): string;

    /**
     * @param string $trackingNumber
     * @return \Tmo\SimpleReturns\Api\Data\LabelInterface
     */
    public function setTrackingNumber(string $trackingNumber): LabelInterface;
}
