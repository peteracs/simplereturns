<?php
/**
 * SimpleReturnSearchResultsInterface.php
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

use Magento\Framework\Api\SearchResultsInterface;

interface SimpleReturnSearchResultsInterface extends SearchResultsInterface
{
    /**
     * @return \Tmo\SimpleReturns\Api\Data\SimpleReturnInterface[]
     */
    public function getItems();

    /**
     * @param \Tmo\SimpleReturns\Api\Data\SimpleReturnInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
