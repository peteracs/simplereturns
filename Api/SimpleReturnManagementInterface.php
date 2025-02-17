<?php
/**
 * SimpleReturnManagementInterface.php
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
    Api\Data\PackageInterface,
    Api\Data\SimpleReturnInterface
};

interface SimpleReturnManagementInterface
{
    /**
     * @param \Tmo\SimpleReturns\Api\Data\SimpleReturnInterface $rma
     * @param string $comment
     * @return bool
     */
    public function addOrderComment(SimpleReturnInterface $rma, string $comment): bool;
}
