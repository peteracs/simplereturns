<?php
/**
 * PackageManagementInterface.php
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

namespace Tmo\SimpleReturns\Api;

use Tmo\SimpleReturns\{
    Api\Data\LabelInterface,
    Api\Data\PackageInterface
};

interface PackageManagementInterface
{
    /**
     * @param \Tmo\SimpleReturns\Api\Data\PackageInterface $package
     * @return \Tmo\SimpleReturns\Api\Data\LabelInterface|null
     */
    public function createShipmentPackages(PackageInterface $package): array;
}
