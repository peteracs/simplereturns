<?php
/**
 * LabelRepositoryInterface.php
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

interface LabelRepositoryInterface extends AbstractRepositoryInterface
{
    /**
     * @param \Tmo\SimpleReturns\Api\Data\PackageInterface $package
     * @return \Tmo\SimpleReturns\Api\Data\LabelInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function get(Data\PackageInterface $package): Data\LabelInterface;

    /**
     * @param int $id
     * @return \Tmo\SimpleReturns\Api\Data\LabelInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById(int $id): Data\LabelInterface;

    /**
     * @param \Tmo\SimpleReturns\Api\Data\LabelInterface $label
     * @return int
     */
    public function save(Data\LabelInterface $label): int;

    /**
     * @param \Tmo\SimpleReturns\Api\Data\LabelInterface $label
     * @return bool
     */
    public function delete(Data\LabelInterface $label): bool;
}
