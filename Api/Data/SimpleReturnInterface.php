<?php
/**
 * SimpleReturnInterface.php
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

use Magento\Sales\Api\Data\OrderInterface;

interface SimpleReturnInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @param int $id
     * @return \Tmo\SimpleReturns\Api\Data\SimpleReturnInterface
     */
    public function setId($id);

    /**
     * @return string
     */
    public function getCreatedAt();

    /**
     * @param string $createdAt
     * @return \Tmo\SimpleReturns\Api\Data\SimpleReturnInterface
     */
    public function setCreatedAt($createdAt);

    /**
     * @return int|null
     */
    public function getPackageId(): ?int;

    /**
     * @param int|null $pkgId
     * @return \Tmo\SimpleReturns\Api\Data\SimpleReturnInterface
     */
    public function setPackageId(?int $pkgId): SimpleReturnInterface;

    /**
     * @return string
     */
    public function getRemoteIp(): string;

    /**
     * @param string $remoteIp
     * @return \Tmo\SimpleReturns\Api\Data\SimpleReturnInterface
     */
    public function setRemoteIp(string $remoteIp): SimpleReturnInterface;
}
