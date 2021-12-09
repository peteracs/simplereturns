<?php
/**
 * AttachmentInterface.php
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

interface AttachmentInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @param int $id
     * @return \Tmo\SimpleReturns\Api\Data\AttachmentInterface
     */
    public function setId($id);

    /**
     * @return string
     */
    public function getCreatedAt();

    /**
     * @param string $createdAt
     * @return \Tmo\SimpleReturns\Api\Data\AttachmentInterface
     */
    public function setCreatedAt($createdAt);

    /**
     * @return int|null
     */
    public function getRmaId(): ?int;

    /**
     * @param int $rmaId
     * @return \Tmo\SimpleReturns\Api\Data\AttachmentInterface
     */
    public function setRmaId(int $rmaId): AttachmentInterface;

    /**
     * @return string|null
     */
    public function getFilename(): ?string;

    /**
     * @param string $filename
     * @return \Tmo\SimpleReturns\Api\Data\AttachmentInterface
     */
    public function setFilename(string $filename): AttachmentInterface;

    /**
     * @return int|null
     */
    public function getFilesize(): ?int;

    /**
     * @param int $filesize
     * @return \Tmo\SimpleReturns\Api\Data\AttachmentInterface
     */
    public function setFilesize(int $filesize): AttachmentInterface;

    /**
     * @return string|null
     */
    public function getFilePath(): ?string;

    /**
     * @param string $filePath
     * @return \Tmo\SimpleReturns\Api\Data\AttachmentInterface
     */
    public function setFilePath(string $filePath): AttachmentInterface;

    /**
     * @return string|null
     */
    public function getMimeType(): ?string;

    /**
     * @param string $mimeType
     * @return \Tmo\SimpleReturns\Api\Data\AttachmentInterface
     */
    public function setMimeType(string $mimeType): AttachmentInterface;

    /**
     * @return string|null
     */
    public function getThumbnail(): ?string;

    /**
     * @param string $filePath
     * @return \Tmo\SimpleReturns\Api\Data\AttachmentInterface
     */
    public function setThumbnail(string $filePath): AttachmentInterface;

    /**
     * @return string|null
     */
    public function getToken(): ?string;

    /**
     * @param string $token
     * @return \Tmo\SimpleReturns\Api\Data\AttachmentInterface
     */
    public function setToken(string $token): AttachmentInterface;
}
