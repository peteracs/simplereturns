<?php
/**
 * EventManagerTrait.php
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT License, which
 * is bundled with this package in the file LICENSE.txt.
 *
 * It is also available on the Internet at the following URL:
 * https://docs.auroraextensions.com/magento/extensions/2.x/simplereturns/LICENSE.txt
 *
 * @package       Tmo_SimpleReturns
 * @copyright     Copyright (C) 2019 Aurora Extensions <support@auroraextensions.com>
 * @license       MIT License
 */
declare(strict_types=1);

namespace Tmo\SimpleReturns\Component\Event;

/**
 * @api
 * @since 1.1.0
 */
trait EventManagerTrait
{
    /** @property Magento\Framework\Event\ManagerInterface $eventManager */
    private $eventManager;

    /**
     * @param string $event
     * @param array $data
     * @return void
     */
    private function dispatchEvent(string $event, array $data = []): void
    {
        $this->eventManager
            ->dispatch($event, $data);
    }

    /**
     * @param array $events
     * @return void
     */
    private function dispatchEvents(array $events = []): void
    {
        /** @var string $event */
        /** @var array $data */
        foreach ($events as $event => $data) {
            $this->dispatchEvent($event, $data);
        }
    }
}
