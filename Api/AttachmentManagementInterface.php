<?php
/**
 * AttachmentManagementInterface.php
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

interface AttachmentManagementInterface
{
    /**
     * @param \Tmo\SimpleReturns\Api\Data\AttachmentInterface $attachment
     * @return string
     */
    public function getFileDataUri(Data\AttachmentInterface $attachment): string;

    /**
     * @param \Tmo\SimpleReturns\Api\Data\AttachmentInterface $attachment
     * @return string
     */
    public function getFileUrl(Data\AttachmentInterface $attachment): string;
}
